<script setup>
import Container from "../../../Components/Container.vue";
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue'
import PrimaryBtn from '../../../Components/PrimaryBtn.vue'
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import SessionMessages from '../../../Components/SessionMessages.vue'
import {router, useForm} from "@inertiajs/vue3";
const resend = (e)=>{
    router.post(route('verification.send'),{

    },{
        onStart:()=>e.target.disabled = true,
        onFinish:()=>e.target.disabled = false
    })
}
const props = defineProps({
    user:Object,
    status:String
})
const form = useForm({
    name: props.user.name,
    email: props.user.email,
})
</script>
<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>Update your account's profile information and email address.</p>
        </div>
        <ErrorMessages :errors="form.errors"/>
        <form
            @submit.prevent="form.patch(route('profile.info'))"
            class="space-y-6">
            <InputField
            label="Name"
            icon="id-badge"
            class="w-1/2"
            v-model="form.name"
            />
            <InputField
                label="Email"
                icon="at"
                class="w-1/2"
                v-model="form.email"
            />
            <div v-if="user.email_verified_at === null">
                <SessionMessages :status="status"/>
                <p>Your email address is unverified.
                    <button
                        @click="resend"
                        class="text-indigo-500 font-medium underline dark:text-indigo-400 dark:hover:text-indigo-500 disabled:cursor-wait disabled:text-slate-400"
                    >Click here to re-send the verification email.</button>
                </p>

            </div>
            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
</template>
