<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import {useForm} from "@inertiajs/vue3";
import ErrorMessages from "../../Components/ErrorMessages.vue";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});
const submit = ()=>{
    form.post(route("register"),{
        onError:()=> form.reset("password", "password_confirmation"),
    });
}
</script>
<template>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Register a new account?</Title>
            <p>
                Already have an account?
                <TextLink route-name="home" label="Login"></TextLink>
            </p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form class="space-y-6" @submit.prevent="submit">
            <InputField label="Name" icon="id-badge" v-model="form.name" />

            <InputField label="Email" type="email" icon="at" v-model="form.email"/>

            <InputField label="Password" type="password" icon="key" v-model="form.password"/>

            <InputField label="Confirm Password" type="password" icon="key" v-model="form.password_confirmation"/>

            <p class="text-slate-500 text-sm dark:text-slate-400">
                By creating an account, you agree to our Terms of Service and
                Privacy Policy.
            </p>
            <PrimaryBtn :disabled="form.processing">Register</PrimaryBtn>
        </form>
    </Container>
</template>
