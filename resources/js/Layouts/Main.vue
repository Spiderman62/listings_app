<script setup>
import {switchThemeOnLoad} from "../theme.js";
import NavLink from "../Components/NavLink.vue";
</script>

<template>
    <header class="bg-slate-800 text-white">
        <nav class="p-6 mx-auto max-w-screen-xl flex items-center justify-between">
            <NavLink route-name="home" component-name="Home">Home</NavLink>
            <div class="flex items-center space-x-6">
                <NavLink route-name="register" component-name="Auth/Register">Register</NavLink>
                <button @click="switchThemeOnLoad"
                    class="hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover:outline outline-1 outline-white">
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="p-6 mx-auto max-w-screen-xl">
        <slot />
    </main>
</template>
