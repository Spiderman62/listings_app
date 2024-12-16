<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import {useForm} from "@inertiajs/vue3";
import ErrorMessages from "../../Components/ErrorMessages.vue";
const props = defineProps({
    token:String,
    email:String,
})
const form = useForm({
    email: props.email,
    token: props.token,
    password: null,
    password_confirmation: null,
});
const submit = ()=>{
    form.post(route("password.update"),{
        onFinish:()=> form.reset("password", "password_confirmation"),
    });
}
</script>
<template>
    <Head title="- Reset password"></Head>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Enter the new password?</Title>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form class="space-y-6" @submit.prevent="submit">
            <InputField label="Email" type="email" icon="at" v-model="form.email"/>
            <InputField label="Password" type="password" icon="key" v-model="form.password"/>
            <InputField label="Confirm Password" type="password" icon="key" v-model="form.password_confirmation"/>
            <PrimaryBtn :disabled="form.processing">Reset password</PrimaryBtn>
        </form>
    </Container>
</template>
