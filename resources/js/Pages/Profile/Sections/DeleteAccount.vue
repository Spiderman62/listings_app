<script setup>
import Container from "../../../Components/Container.vue";
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue'
import PrimaryBtn from '../../../Components/PrimaryBtn.vue'
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import SessionMessages from '../../../Components/SessionMessages.vue'
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
const showConfirmPassword = ref(false);
const setShowConfirmPassword = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
}
const form = useForm({
    password:null
});
const submit = ()=>{
    form.delete(route('profile.destroy'),{
        onFinish:()=> form.reset(),
        preserveScroll:true
    })
}
</script>
<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>Once your account is deleted, all of its resources data will be permanently delete. This action cannot be undone.</p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <div >
            <form
                v-if="showConfirmPassword"
                @submit.prevent="submit"
                class="space-y-6 flex items-center gap-4">
                <InputField
                    type="password"
                    label="Password"
                    icon="key"
                    class="w-1/2"
                    v-model="form.password"
                />

                <PrimaryBtn>Confirm</PrimaryBtn>
                <button @click="setShowConfirmPassword" class="text-indigo-500 font-medium underline dark:text-indigo-400">Cancel</button>
            </form>
            <button
                v-else
                @click="setShowConfirmPassword"
                class="px-6 py-2 rounded-lg bg-red-500 text-white">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                Delete account</button>
        </div>

    </Container>
</template>
