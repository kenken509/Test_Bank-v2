<template>
    
    <div class="flex flex-col h-[100vh] justify-center items-center">
        <div v-if="form.errors.email">
            <InputError :error="form.errors.email"/>
        </div>
       
        <div class="flex flex-col w-full xs:w-[95%]  md:w-[35%] text-gray-300  border border-gray-400 rounded-md">
            <div class="flex  flex-col w-full items-center justify-center bg-blue-900 text-gray-200  rounded-t-md pl-2 shadow-md">
                <div class="flex justify-center items-center pt-4 ">
                    <img :src="logoUrl" alt="error" class="w-[50px] h-[50px]"/>
                </div>
                <div class="  py-2 xs:text-sm md:text-xl">
                    LOGIN PAGE
                </div>
            </div>
           
            <div class="flex justify-center items-center w-full  pt-4 ">
                <form @submit.prevent="login" class="w-full px-4 ">
                    <div class="flex flex-col  gap-5 ">
                        <div class="">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input v-model="form.email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="email" required />
                        </div>
                        <div >
                            <label for="passWord" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input v-model="form.password" type="password" id="passWord" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="password" required />
                        </div>
                    </div>

                    <!-- submit button-->
                    <div class="mt-4">
                        <button 
                            type="submit" 
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        >   Login
                        </button>
                    </div>
                    <!-- submit button-->
                </form>
            </div>  
        </div>

        
    </div>
    
</template>

<script setup>
import {ref} from 'vue'
import { useForm } from '@inertiajs/vue3';
import InputError from '../Global Component/InputError.vue';



const logoUrl = ref('/storage/Images/ncstLogo.png')

const form = useForm({
    email:null,
    password:null,
})


const login = ()=> {
    form.post(route('login.store'))
}

const counter = ref(0);

setInterval(() => {
    counter.value++
}, 1000);
</script>