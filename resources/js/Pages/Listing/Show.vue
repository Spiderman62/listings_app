<script setup>
import Container from "../../Components/Container.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean,
})
const deleteListing = () => {
    if (confirm("Are you sure you want to delete?")) {
        router.delete(route('listing.destroy', props.listing.id));
    }
}
const toggleApprove = ()=>{
    let msg = props.listing.approved ? 'Disapproved this listing?': 'Approved this listing?';
    if(confirm(msg)){
        router.put(route('admin.approve',props.listing.id),{},{
            preserveScroll: true,
        })
    }
}
</script>
<template>
    <Head title="- Listing Detail"/>
    <!--  Admin  -->
    <div v-if="$page.props.auth.user.role === 'admin'"
    class="bg-slate-800 text-white mb-6 p-6 rounded-md font-medium flex items-center justify-between"
    >
        <p>This listing is {{listing.approved ? 'approved' : 'Disapproved'}}.</p>
        <button @click.prevent="toggleApprove" class="bg-slate-600 px-3 py-1 rounded-md">
            {{listing.approved ? 'Disapproved it' : 'approved it'}}
        </button>
    </div>
    <Container class="flex gap-4">
        <div class="w-1/4 rounded-md overflow-hidden">
            <img :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listings/default.jpg'" alt=""
                 class="w-full h-full object-center object-cover"
            >
        </div>
        <div class="w-3/4">
            <!--      Listing info      -->
            <div class="mb-6">
                <div class="flex items-end justify-between mb-2">
                    <p class="text-slate-400 w-full border-b">Listing detail</p>
                    <!--        Edit and delete button        -->
                    <div v-if="canModify" class="pl-4 flex items-center gap-4">
                        <Link
                            :href="route('listing.edit',listing.id)"
                            class="bg-green-500 rounded-md text-white px-6 py-2 hover:outline outline-green-500 outline-offset-2"
                        >Edit
                        </Link>
                        <button
                            @click="deleteListing"
                            class="bg-red-500 rounded-md text-white px-6 py-2 hover:outline outline-red-500 outline-offset-2"
                        >Delete
                        </button>
                    </div>
                </div>
                <h3 class="font-bold text-2xl mb-4">{{ listing.title }}</h3>
                <p>{{ listing.desc }}</p>
            </div>
            <!--  Contact info  -->
            <div class="mb-6">
                <p class="text-slate-400 w-full border-b mb-2">Contact info</p>
                <!--        Email        -->
                <div v-if="listing.email" class="flex item-center mb-2 gap-2">
                    <i class="fa-solid fa-at flex items-center"></i>
                    <p>Email: </p>
                    <a :href="`mailto:${listing.email}`"
                       class="text-link"
                    >
                        {{ listing.email }}
                    </a>
                </div>
                <!--       Link        -->
                <div v-if="listing.link" class="flex item-center mb-2 gap-2">
                    <i class="fa-solid fa-up-right-from-square flex items-center"></i>
                    <p>External link: </p>
                    <a target="_blank" :href="listing.link"
                       class="text-link"
                    >
                        {{ listing.link }}
                    </a>
                </div>
                <!--        User        -->
                <div class="flex item-center mb-2 gap-2">
                    <i class="fa-solid fa-user flex items-center"></i>
                    <p>Listed by: </p>
                    <Link :href="route('home',{user_id:user.id})"
                          class="text-link"
                    >
                        {{ user.name }}
                    </Link>
                </div>
            </div>
            <div v-if="listing.tags" class="mb-6">
                <p class="text-slate-400 w-full border-b mb-2">Tags</p>
                <div class="flex item-center gap-3">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">
                        <Link
                            :href="route('home',{ tag})"
                            class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 dark:hover:bg-slate-900">
                            {{ tag }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>
