<template>
    <DashboardLayout>
        <Dialog v-model:visible="customModalOpen" modal  :style="{ width: '50rem' }">
            <ModalHeader title="Test Gen">
              <!-- random option check: {{ department[0].subject_codes[0].questions[0].options[0] }} -->
               <!-- prelim: {{ isPrelim }} || midter: {{ isMidterm }} || prefinal: {{ isPrefinal }} || final: {{ isFinal }} -->
               <!--prelim: {{ prelimItems }} || midterm: {{ midTermItems }} || prefinal: {{ preFinalItems }} || final: {{ finalItems }}-->
              prelim count: {{prelimQuestionCount}} || total items: {{ totalItems }}
                <form>   
                    <div class="w-full">
                        <div class="flex w-full pr-4 gap-2 flex-col  md:items-center md:flex-row py-2 ">
                            <label for="department" class="text-black font-semibold w-full max-w-[150px]">Department: </label>
                            <select id="department" v-model="selectedDepartment" class="rounded-md w-full" >
                                <option value="" hidden disabled>Select department </option>
                                <option v-for="dep in departmentOptions" :key="dep.id" :value="dep">
                                    {{ dep.name }} 
                                </option>
                            </select>
                        </div>
                       
                        <div class="flex w-full pr-4 gap-2 flex-col py-2 md:items-center md:flex-row">
                            <label for="subject_codes" class="text-black font-semibold w-full max-w-[150px]">Subject Code: </label>
                            <select id="subject_codes" v-model="selectedSubjectCode" class="rounded-md w-full" >
                                <option  value="" hidden disabled>Select subject code </option>
                                <option v-for="code in selectedDepartment.subject_codes" :key="code.id" :value="code">
                                    {{ code.name }}
                                </option>
                            </select>
                        </div>
                        <div class="flex w-full pr-4 gap-2 flex-col py-2 md:items-center md:flex-row">
                            <label for="description" class="text-black font-semibold w-full max-w-[150px]">Subject Code: </label>
                            <input id="description" type="text" :placeholder="selectedSubjectCode.description" class="bg-gray-100 rounded-md w-full" disabled/>
                        </div>
                    </div>
                    <div class="mt-2">
                        <hr>
                    </div>
                    <div class="my-2">
                        <span class="text-black font-semibold">Select Term: </span>
                    </div>
                    <div class="w-full m-auto border px-4 bg-blue-100 rounded-md shadow-inner ">
                        <div class="w-full grid grid-cols-5 gap-2 my-2">
                            <div class="col-span-1 flex items-center gap-2 ">
                                <input v-model="isPrelim" id="prelim_chkbx" type="checkbox" class="hover:cursor-pointer rounded-sm" value="prelim" />
                                <label for="prelim_chkbx" class="hover:cursor-pointer text-black">Prelim</label>
                            </div>
                            <div class="col-span-1 flex items-center ">
                                <label class="text-black">Print : </label>
                            </div>
                            <div class="col-span-3 flex items-center justify-evenly ">
                                <input v-model="prelimQuestionCount" class="max-w-[100px] rounded-md mr-2" it="testNum" type="number" max="50" min="0"/>  of  <input class="max-w-[100px] rounded-md ml-2  shadow-md" id="maxTestNum" type="number" :max="prelimItems.length" :placeholder="prelimItems.length" disabled/>
                            </div>
                        </div>

                        <div class="w-full grid grid-cols-5 gap-2 my-2">
                            <div class="col-span-1 flex items-center gap-2 ">
                                <input v-model="isMidterm" id="midterm_chkbx" type="checkbox" class="hover:cursor-pointer rounded-sm" value="prelim" />
                                <label for="midterm_chkbx" class="hover:cursor-pointer text-black">Mid-term</label>
                            </div>
                            <div class="col-span-1 flex items-center ">
                                <label class="text-black">Print : </label>
                            </div>
                            <div class="col-span-3 flex items-center justify-evenly ">
                                <input v-model="midtermQuestionCount" class="max-w-[100px] rounded-md mr-2" it="testNum" type="number" max="50" min="0"/>  of  <input class="max-w-[100px] rounded-md ml-2  shadow-md" id="maxTestNum" type="number" :max="midTermItems.length" :placeholder="midTermItems.length" disabled/>
                            </div>
                        </div>

                        <div class="w-full grid grid-cols-5 gap-2 my-2">
                            <div class="col-span-1 flex items-center gap-2 ">
                                <input v-model="isPrefinal" id="prefinal_chkbx" type="checkbox" class="hover:cursor-pointer rounded-sm" value="prelim" />
                                <label for="prefinal_chkbx" class="hover:cursor-pointer text-black">Pre-final</label>
                            </div>
                            <div class="col-span-1 flex items-center ">
                                <label class="text-black">Print : </label>
                            </div>
                            <div class="col-span-3 flex items-center justify-evenly ">
                                <input v-model="prefinalQuestionCount" class="max-w-[100px] rounded-md mr-2" it="testNum" type="number" max="50" min="0"/>  of  <input class="max-w-[100px] rounded-md ml-2  shadow-md" id="maxTestNum" type="number" :max="preFinalItems.length" :placeholder="preFinalItems.length" disabled/>
                            </div>
                        </div>

                        <div class="w-full grid grid-cols-5 gap-2 my-2">
                            <div class="col-span-1 flex items-center gap-2 ">
                                <input v-model="isFinal" id="final_chkbx" type="checkbox" class="hover:cursor-pointer rounded-sm" value="prelim" />
                                <label for="prefinal_chkbx" class="hover:cursor-pointer text-black">Final</label>
                            </div>
                            <div class="col-span-1 flex items-center ">
                                <label class="text-black">Print : </label>
                            </div>
                            <div class="col-span-3 flex items-center justify-evenly ">
                                <input v-model="finalQuestionCount" class="max-w-[100px] rounded-md mr-2" it="testNum" type="number" max="50" min="0"/>  of  <input class="max-w-[100px] rounded-md ml-2  shadow-md" id="maxTestNum" type="number" :max="finalItems.length" :placeholder="finalItems.length" disabled/>
                            </div>
                        </div>
                      
                       
                    </div>
                    <div class="mt-2">
                        <hr>
                    </div>
                    <div class="mt-2">
                        <div class="flex gap-2  flex-col md:flex-row md:items-center">
                            <label for="schoolyr">School Year : </label>
                            <select id="schoolyr" class="rounded-md">
                                <option value="" hidden disabled>Select school year</option>
                                <option v-for="(year,index) in schoolYear" :key="index" >
                                    {{ year }}
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </ModalHeader>
           <!-- <span class="text-red-500"> {{ department }}</span> -->
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
import {ref,onMounted, computed,watch} from 'vue'
import { useForm } from '@inertiajs/vue3';
const customModalOpen = ref(true)

const closeModal = () => {
   customModalOpen.value = false;
};

onMounted(()=>{
    
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
                    name:dep.name+' '+div.name,
                    subject_codes:dep.subject_codes.filter((code)=> code.division_id===div.id)
                })
            })
        }
        else
        {
            options.push({
                id:dep.id,
                division_id:null,
                name:dep.name,
                subject_codes:dep.subject_codes,
            })
        }
        
    })

    return options
})
const selectedTerm = ref('');

const isPrelim = ref(false);
const isMidterm = ref(false);
const isPrefinal = ref(false);
const isFinal = ref(false);

const prelimItems   = ref([]);
const midTermItems  = ref([]);
const preFinalItems = ref([]);
const finalItems    = ref([]);
const totalItems    = computed(()=>{
    let count = 0
    count = prelimItems.value.length+midTermItems.value.length+preFinalItems.value.length+finalItems.value.length

    return count
});

const prelimQuestionCount   = ref('');
watch(prelimQuestionCount,(count)=>{
    
   if(count > prelimItems.value.length)
   {
        prelimQuestionCount.value = ''
   }
})
const midtermQuestionCount  = ref('');
watch(midtermQuestionCount,(count)=>{
    
    if(count > midTermItems.value.length)
    {
        midtermQuestionCount.value = ''
    }
 })
const prefinalQuestionCount = ref('');
watch(prefinalQuestionCount,(count)=>{
    
    if(count > preFinalItems.value.length)
    {
        prefinalQuestionCount.value = ''
    }
 })
const finalQuestionCount    = ref('');
watch(finalQuestionCount,(count)=>{
    
    if(count > finalItems.value.length)
    {
        finalQuestionCount.value = ''
    }
 })
const totalQuestionCount = ref('')

watch(selectedSubjectCode,(code)=>{
    
    if(code)
    {
        prelimItems.value   = code.questions.filter((question)=> question.term==='prelim')
        midTermItems.value  = code.questions.filter((question)=> question.term==='mid-term')
        preFinalItems.value = code.questions.filter((question)=> question.term==='pre-final')
        finalItems.value    = code.questions.filter((question)=> question.term==='final')
    }
    else
    {
        prelimItems.value   = [];
        midTermItems.value  = [];
        preFinalItems.value = [];
        finalItems.value    = [];
    }
    
})


//watchers
watch(selectedDepartment,(val)=>{
   
   
    selectedSubjectCode.value = '';
   
   
})

const schoolYear = ref([
    '2024-2025',
    '2025-2026',
    '2026-2027',
    '2027-2028',
    '2028-2029',
    '2029-2030',
    '2030-2031',
    '2031-2032',
    '2032-2033',
    '2033-2034',
    '2034-2035',
])

</script>

<style scoped>
        /* Hide the spinners for WebKit-based browsers (Chrome, Safari) */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide the spinners for Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>