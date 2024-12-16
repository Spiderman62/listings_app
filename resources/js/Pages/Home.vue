<script setup>
import Card from '../Components/Card.vue'
import PaginatorLink from '../Components/PaginatorLink.vue';
import InputField from '../Components/InputField.vue';
import {useForm, router} from "@inertiajs/vue3";

const params = route().params;

const props = defineProps({
    listings: Object,
    searchTerm: String
})
const username = params.user_id ? props.listings.data.find(i=> i.user_id === parseInt(params.user_id) ).user.name : null;
const form = useForm({
    search: props.searchTerm,
})

const search = () => {
    router.get(route('home'), {
        search: form.search,
        user_id: params.user_id,
        tag: params.tag,
    })
}
</script>

<template>
    <Head title="- Latest Listings"/>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <Link
                class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
                v-if="params.tag" :href="route('home',{...params,tag:null,page:null})">{{ params.tag }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
            <Link
                class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
                v-if="params.search" :href="route('home',{...params,search:null,page:null})">{{ params.search }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
            <Link
                class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
                v-if="params.user_id" :href="route('home',{...params,user_id:null,page:null})">{{ username }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
        </div>
        <div class="w-1/4">
            <form
                @submit.prevent="search"
            >
                <InputField
                    label="Name"
                    type="search"
                    icon="magnifying-glass"
                    placeholder="Search..."
                    v-model.trim="form.search"
                />
            </form>
        </div>
    </div>
    <div v-if="Object.keys(listings.data).length">
        <div class="grid grid-cols-3 gap-4">
            <div v-for="listing in listings.data" :key="listing.id">
                <Card :listing="listing"/>
            </div>
        </div>
        <PaginatorLink class="mt-8" :paginator="listings"/>
    </div>
    <div v-else>
        There are no listings
    </div>
</template>
