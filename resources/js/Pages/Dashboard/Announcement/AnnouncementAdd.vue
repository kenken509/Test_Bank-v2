<template>
    <DashboardLayout>
        <div class="flex items-center justify-between border-bot-only py-2 mb-4">
            <span class="text-[20px] font-bold text-gray-500">New Announcement </span> 
        </div>
        
        <Dialog v-model:visible="announcementModalOpen" modal  :style="{ width: '50rem' }">
            
            <div class=" w-full">
                <h2 class="text-xl font-bold mb-2">New Announcement</h2>
                <div class="w-full border-b border-gray-500 w-full"></div>
            </div> 
            <div class="w-full mt-6 ">
                <form @submit.prevent="submit">
                    <div class="mt-6">
                        <label for="announcement" class="font-semibold ">Content: </label>
                        <textarea v-model="content" id="announcement" class="w-full mt-2 rounded-md" rows="4" cols="50" required></textarea> 
                    </div>
                    <div class="grid grid-cols-8 mt-4 w-full ">
                        <div class="flex items-center gap-4 col-span-2 mt-4 md:col-span-1">
                            <label for="startDate" class="font-semibold ">Start Date: </label>
                        </div>
                        <div class="col-span-6 md:col-span-4">
                            <input v-model="startDate" id="startDate" type="date" class="rounded-md mt-4" required/>
                        </div>
                        
                        <div class="flex items-center gap-2 col-span-2 mt-4 md:col-span-1  md:flex md:justify-end">
                            <label for="endDate" class="font-semibold ">End Date: </label>
                        </div>
                        <div class="col-span-6 mt-4 md:col-span-2 md:flex md:justify-end">
                            <input v-model="endDate" id="endDate" type="date" class="rounded-md" required/>
                        </div>
                    </div>
                    
                    <div class="mt-4 border-t-2 border-gray-300 pt-2">
                        <button class="btn-primary w-full ">Clear</button>
                        <button type='submit'class="btn-primary w-full" :disabled="form.processing">Save</button>
                    </div>
                    
                </form>
            </div>
        </Dialog>
            
        
    </DashboardLayout>
    
</template>
<script setup>
import {ref, onMounted} from 'vue'
import DashboardLayout from '../DashboardLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const announcementModalOpen = ref(false)

onMounted(()=>{
    announcementModalOpen.value = true
})

const user = usePage().props.user
const form = useForm({
    startDate:'',
    endDate:'',
    content:'',
    author:user.id,
})

const startDate = ref('')
const endDate = ref('')
const content = ref('')
const noError = ref(true);

const currentDate = ref(new Date()) 

const submit = ()=>{

    
    if(startDate.value)
    {
        let selectedDate = new Date(startDate.value)
        selectedDate.setHours(0, 0, 0, 0);
        currentDate.value.setHours(0, 0, 0, 0);

        if(selectedDate < currentDate.value)
        {
            noError.value = false
            return
        }
    }

    if(noError.value)
    {
        alert('submit');
    }
    
}

function errorMessate()
{

}
</script>