<template>
    <DashboardLayout>
        <Dialog v-model:visible="customModalOpen" modal  :style="{ width: '80rem' }">
            <ModalHeader title="Test Gen">
                <form>   
                    <div class="w-full">
                        <div class="flex w-full pr-4 gap-2 flex-col py-2 ">
                            <label for="department" class="text-black font-semibold">Department: </label>
                            <select id="department" v-model="selectedDepartment" class="rounded-md w-full" >
                                <option value="" hidden disabled>Select department </option>
                                <option v-for="dep in departmentOptions" :key="dep.id" :value="dep">
                                    {{ dep.name }} 
                                </option>
                            </select>
                        </div>
                        {{ departmentOptions }}
                        <!-- <div  class="flex w-full pr-4 gap-2 flex-col py-2 ">
                            <label for="subject_code" class="text-black font-semibold">Subject Code: </label>
                            <select id="subject_code" v-model="selectedSubjectCode" class="rounded-md w-full" >
                                <option value="" hidden disabled>Select subject code </option>
                                <option v-for="code in selectedDepartment.subject_codes" :key="code.id" :value="dep">
                                    {{ code.name }}
                                </option>
                            </select>
                        </div>
                        {{ selectedSubjectCode }}sdf
                        <div  class="flex w-full pr-4 gap-2 flex-col ">
                            <label for="description" class="text-black font-semibold">Description: </label>
                            <input id="description" type="text"  />
                        </div> -->
                    </div>
                </form>
            </ModalHeader>
           <span class="text-red-500"> {{ department }}</span>
            <div class="w-full">
                <button @click="handleSave" type="button" class="btn-primary" >saves</button>
            </div>
            <div class="save-data">
                <span>
                    {{ data.department[0].name }} aries
                </span>
            </div>
        </Dialog>
        
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../DashboardLayout.vue';
import CustomModal from '../../Global Component/CustomModal.vue';
import ModalHeader from '../Components/ModalHeader.vue'
import {ref,onMounted, computed} from 'vue'
import { useForm } from '@inertiajs/vue3';
const customModalOpen = ref(true)

const closeModal = () => {
   customModalOpen.value = false;
};

onMounted(()=>{
    selectedDepartment.value = data.department[0]
})
const data = defineProps({
    department:Array,
})

const form = useForm({
    test:'1',
})
const saveDataContent = ref('');


const openPreviewInNewTab = () => {
    const data = encodeURIComponent(saveDataContent.value);
    const url = `/preview?data=${data}`;
    window.open(url, '_blank');
};

//
const selectedDepartment = ref('');
const selectedSubjectCode = ref('');
const departmentOptions = computed(()=>{
    let options = []

    data.department.forEach((dep)=>{
        if(dep.divisions.length)
        {
            dep.divisions.forEach((div)=>{
                options.push({
                    id:dep.id,
                    division_id:div.id,
                    name:dep.name+' '+div.name
                })
            })
        }
        else
        {
            options.push({
            id:dep.id,
            division_id:null,
            name:dep.name,
        })
        }
        
    })

    return options
})


</script>