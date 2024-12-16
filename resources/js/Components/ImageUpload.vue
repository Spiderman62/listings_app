<script setup>
import {ref} from "vue";

const props = defineProps({
    listingImage: String
})
const emit = defineEmits(['image']);
const currentImage = props.listingImage ? `/storage/${props.listingImage}` : null;
const preview = ref(currentImage);
const overSizedImage = ref(false);
const showRevertBtn = ref(false);
const selectedImage = e => {
    preview.value = URL.createObjectURL(e.target.files[0]);
    overSizedImage.value = e.target.files[0].size > 3145728;
    showRevertBtn.value = true;
    emit("image", e.target.files[0]);
}
const revertImageChange = ()=>{
    showRevertBtn.value = false;
    preview.value = currentImage;
    overSizedImage.value = false;
    emit("image", null);
}
</script>
<template>
    <div>
        <span
            class="block text-sm font-medium text-slate-700 dark:text-slate-300"
            :class="{'!text-red-500':overSizedImage}"
        >

            {{ overSizedImage ? 'The selected image exceeds 3Mb' : 'Image (Max size 3Mb)' }}
        </span>
        <label for="image"
               :class="{'!border-red-500':overSizedImage}"
               class="block rounded-md mt-1 bg-slate-300 h-[138px] overflow-hidden cursor-pointer border-slate-300 border relative">
            <img class="size-full object-cover object-center" :src="preview ?? '/storage/images/listings/default.jpg'"
                 alt="">
            <button
                v-if="showRevertBtn"
                class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full grid place-items-center text-slate-700"
                type="button"
                @click.prevent="revertImageChange"
            >
                <i class="fa-solid fa-rotate-left"></i>
            </button>
        </label>
        <input @input="selectedImage" type="file" id="image" name="image" hidden>
    </div>
</template>
