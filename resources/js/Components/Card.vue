<script setup>
import {router} from "@inertiajs/vue3";
const params = route().params;
defineProps({
    listing:Object
})
const selecteUser = (user_id)=>{
    router.get(route('home'),{
        user_id : user_id,
        search:params.search,
        tag:params.tag,
    })
}
const selecteTag = (tag)=>{
    router.get(route('home'),{
        user_id : params.user_id ,
        search:params.search,
        tag:tag,
    })
}
</script>
<template>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden dark:bg-gray-800 h-full flex flex-col justify-between">
        <div>
            <Link
            :href="route('listing.show',listing.id)"
            >
                <img class="w-full h-48 object-cover object-center bg-slate-300" :src="listing.image ? `storage/${listing.image}` : 'storage/images/listings/default.jpg'" alt="">
            </Link>
            <div class="p-4">
<!--                <h3 class="font-bold text-xl mb-2">-->
<!--                    {{listing.title.substring(0,40)}}...-->
<!--                </h3>-->
                <h3 class="font-bold text-xl mb-2 line-clamp-2">
                    {{listing.title}}
                </h3>
                <p>Listed on {{new Date(listing.created_at).toLocaleDateString()}} by
                    <button class="text-link" @click="selecteUser(listing.user.id)">
                        {{listing.user.name}}
                    </button>
                </p>
            </div>
        </div>
        <div v-if="listing.tags">
            <div class="flex items-center gap-3 px-4 pb-4">
               <div v-for="tag in listing.tags.split(',')" :key="tag">
                   <button @click="selecteTag(tag)" class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 dark:hover:bg-slate-900">{{tag}}</button>
               </div>
            </div>
        </div>
    </div>
</template>
