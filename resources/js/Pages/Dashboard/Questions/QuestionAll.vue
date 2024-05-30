<template>
    <DashboardLayout>
        <div class="flex items-center justify-between border-bot-only py-2 mb-4">
            <span class="text-[20px] font-bold text-gray-500">Questions Page </span> 
            <!-- <div class="relative">
                <input v-model="searchField" type="text" placeholder="search" class="rounded-md">
                <svg class="absolute top-3 right-2 w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                </svg>
            </div>  -->
        </div>
        <!-- current codes:  {{ filteredQuestionByCode }} || hasFilteredTerm = {{ hasFilteredTerm }}
        <span class="text-red-700">{{ getDisplayedQuestions() }}</span> -->
        <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success) }} </div>
        <div v-if="$page.props.flash.error" >{{ errorMessage($page.props.flash.error) }} </div>

            <div class="flex  flex-col ">
                <div class="grid grid-cols-10 items-center my-2 ">
                    <div class="col-span-1">
                        <label>Subject Code: </label>
                    </div>
                    
                    <div class="flex  col-span-10 lg:col-span-8 gap-8 ">
                        
                        <select  v-model="selectedSubjectCode" class="border-blue-500 rounded-md ">
                            <option value="" selected hidden>
                                Subject Code
                            </option>
                            <option v-for="code in data.subjectCodes" :value="code">
                                {{ code.name }}
                            </option>
                        </select>
                        <div class="flex flex-col lg:flex-row  gap-3" > 
                            <span class="flex items-center"> Term: </span>   
                            <div class="flex items-center gap-4 hover:cursor-pointer  " :class="{'pointer-events-none ': allTermsSelected}">
                                <input v-model="prelim" type="checkbox" id="prelim" class="hover:cursor-pointer "  />
                                <label for="prelim" class="hover:cursor-pointer" >Prelim</label>
                            </div>
                            <div class="flex items-center gap-4 hover:cursor-pointer" :class="{'pointer-events-none ': allTermsSelected}">
                                <input v-model="midTerm" type="checkbox" id="midterm" class="hover:cursor-pointer" />
                                <label for="midterm" class="hover:cursor-pointer">Midterm</label>
                            </div>
                            <div class="flex items-center gap-4 hover:cursor-pointer" :class="{'pointer-events-none ': allTermsSelected}">
                                <input v-model="prefinal" type="checkbox" id="prefinal" class="hover:cursor-pointer" />
                                <label for="prefinal" class="hover:cursor-pointer">Prefinal</label>
                            </div>
                            <div class="flex items-center gap-4 hover:cursor-pointer" :class="{'pointer-events-none ': allTermsSelected}">
                                <input v-model="final" type="checkbox" id="final" class="hover:cursor-pointer" />
                                <label for="final" class="hover:cursor-pointer">Final</label>
                            </div>
                            
                            
                            <div class="flex items-center gap-4 hover:cursor-pointer">
                                <input v-model="allTerm" type="checkbox" id="all" class="hover:cursor-pointer" />
                                <label for="all" class="hover:cursor-pointer">All</label>
                            </div> 
                        </div>
                    </div>
                    
                   
                    <div class="flex items-center gap-2">
                        <span>
                            Total Count: 
                        </span>
                        <span >
                            {{ questionTotalCoumt }}
                        </span>
                    </div>
                </div>
                
                <div class=" grid grid-cols-10 items-center mb-2">
                    <div class="col-span-1">
                        <span class="">
                            Description : 
                        </span>
                    </div>
                    
                    <div class="col-span-9 w-full">
                        <input type="text" :value="selectedSubjectCode.description" class="w-full bg-gray-100 rounded-md" disabled />
                        <span class="col-span-1">
                            
                        </span>
                    </div>
                </div>
                
                
            </div>
            
            
            
            <!--TABLE--> 
            <div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-200 uppercase bg-blue-900 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No.</th>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Question</th>
                                <th scope="col" class="px-6 py-3">Term</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                                <th scope="col" class="px-6 py-3">Author</th>
                                <th scope="col" class="px-6 py-3">Date</th>
                                
                            

                                
                                <th  v-if="isAdmin" scope="col" class="flex justify-center px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(question ,index ) in getDisplayedQuestions() " :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                {{ getQuestionTotalCount(filteredQuestionByCode.length) }} 
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ index+1 }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ question.id }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ question.question }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ question.term }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ question.type }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ question.author.name }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ formatDate(question.created_at) }}
                                </th>
                            
                            
                                <td  v-if="$page.props.user.role === 'admin'" class="px-6 py-4 text-center ">
                                    <div  class="flex flex-col   lg:flex-row lg:justify-center  lg:space-x-4">
                                        <button @click="showQuestionInfoModal(question)" class="btn-primary p-2">Info</button>
                                        <button  @click="deleteConfirmation(question.id)" class=" btn-warning my-2">Delete </button>
                                        <Link href="" type="button" class="btn-success my-2">
                                            Update
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        
            <!--TABLE-->
         
        

        <!--Question Info Modal-->
        <Dialog v-model:visible="infoModalOpen" modal  :style="{ width: '80rem' }">
            <!--header-->
            <div class="border  flex justify-between items-center bg-blue-900 p-4 pl-2 pr-4 rounded-tl-md rounded-tr-md">
                <div class="flex items-center gap-2">
                    <img :src="logoUrl" alt="error" class="w-20 h-20">
                    <span class="text-gray-100 text-xl">Question information</span>
                </div>
                <div class="flex  flex-col  ">
                    <div class="flex justify-end text-[30px] text-gray-100">
                        {{ user.name }}
                    </div>
                    <div class="flex justify-end text-gray-100">
                        {{ user.role }}
                    </div>
                    
                </div>
            </div>
            <!--header-->

            <!--BODY-->
            <div class=" border-t-0 rounded-bl-md rounded-br-md p-2">
                <div class="flex justify-between my-4 border-b-2 pb-2">
                    <div class="flex flex-col">
                        <div>
                            <span class="text-lg font-semibold"> Subject Code : </span>
                            <span>{{ selectedSubjectCode.name }} </span> 
                        </div>
                        <div>
                            <span class="text-lg font-semibold"> Description : </span>
                            <span>{{ selectedSubjectCode.description }}</span> 
                        </div>
                        
                    </div>
                    <div class="flex flex-col">
                        <div class="pr-4">
                        <span class="text-lg font-semibold">Type: </span>  {{ viewQuestionInfo.type }}
                        </div>
                        <div class="pr-4">
                        <span class="text-lg font-semibold">Id:</span>  {{ viewQuestionInfo.id }}
                        </div>
                    </div>
                </div>
                

                
                <div class="w-full flex gap-2 border border-gray-300 pl-2 py-2 rounded-md shadow-sm ">
                     <!--Left box-->
                    <div class="w-[60%] h-full ">
                        <textarea class="w-full h-[50%] mb-2" cols="40" rows="5" :value="viewQuestionInfo.question">
                        </textarea>
                        <div class=" relative flex  max-h-[30%]  flex-col  ">
                            <div class=" border border-2 border-gray-300 flex flex-col items-center max-w-[150px] p-2">
                                <img :src="viewQuestionInfo.attached_image ? optionUrl+viewQuestionInfo.attached_image:optionUrl+'no_image.png' " alt="error" class=" rounded-md max-h-[100px] max-w-[100px] mb-2 "/>
                                <span>
                                    Attached Image
                                </span>
                                <i v-if="!viewQuestionInfo.attached_image" class="pi pi-ban text-red-400 text-[30px] top-8 absolute z-50"></i>
                            </div>
                            
                        </div>
                        
                    </div>
                    <!--Left box-->
                    {{ getCorrectAnswer(viewQuestionInfo.options) }} 
                    
                    
                    <!--right box-->
                    <div class=" w-[40%] pr-2">
                        <!--text option-->
                        <div v-if="textTab" >
                            
                            <div class="flex items-center gap-2 mb-2" v-for="option in viewQuestionInfo.options" :key="option.id">                    
                                <input type="radio" :name="`options`" :id="`option_${option.id}`" :value="option.id" v-model="correctAnswer" />
                                <textarea cols="30" rows="2" class="w-full" :value="option.option">  </textarea>
                            </div>
                        </div>
                        <!--text option-->

                        <!--image option-->
                        <div v-if="imageTab" class="grid grid-cols-2  " >
                            
                            <div class="items-center gap-2 mb-2 col-span-2 md:col-span-1 h-[140px]  flex items-center justify-center" v-for="option in viewQuestionInfo.options" :key="option.id">                    
                                <input type="radio" :name="`options`" :id="`option_${option.id}`" :value="option.id" v-model="correctAnswer" />
                                <div class="border p-2 border-gray-400 ">
                                    <img :src="optionUrl+option.option" class="max-h-[100px] max-w-[100px]"/>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <!--right box-->
                </div>
            </div>
            <!--BODY-->


           
            <div class="flex flex-col align-items-center gap-3 mb-3">
                <label for="username" class="font-semibold w-6rem"></label>
                
               
            </div>
            
           
        </Dialog>

        <!--Question Info Modal-->
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../DashboardLayout.vue';
import {ref,watch,onMounted} from 'vue'
import { Link,usePage,router } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js'

function getCorrectAnswer(options)
{
    options.forEach((option) => {
        if (option.isCorrect === 'true') {
            correctAnswer.value = option.id;
        }
    });
    // options.foreach((option)=>{
    //     if(option.isCorrect)
    //     {
    //         correctAnswer.value = option.id
    //     }
    // })
}
const correctAnswer= ref('')
const logoUrl = ref('/storage/Images/ncstLogo.png');
const optionUrl = ref('/storage/Images/');
const searchField = ref('')



const data = defineProps({
    subjectCodes:Array,
})

const user = usePage().props.user
const isAdmin = ref(false);
onMounted(()=>{
    if(user.role === 'admin')
    {
        isAdmin.value = true;
    }

    selectedSubjectCode.value = data.subjectCodes[0]
    filteredQuestionByCode.value = selectedSubjectCode.value.questions
    
})





function formatDate(dateString){
    const date = new Date(dateString)

    const options = { year: 'numeric', month: 'long', day: 'numeric' };

    return date.toLocaleDateString('en-US', options);
}
const infoModalOpen = ref(false);
const viewQuestionInfo = ref('');
const showQuestionInfoModal = (question)=>{
    infoModalOpen.value = !infoModalOpen.value
    viewQuestionInfo.value = question

    if(question.type === 'text')
    {
        
        textTab.value = true;
        imageTab.value = false;
    }
    
    if(question.type === 'image')
    {
        imageTab.value = true
        textTab.value = false
    }
    
}

watch(infoModalOpen,(val)=>{
    if(!val){
        viewQuestionInfo.value =''
    }
})

const prelim = ref(false);
const midTerm = ref(false);
const prefinal = ref(false);
const final = ref(false);

const selectedSubjectCode = ref('');
const currentSubjectCodes = ref('')
const filteredQuestionByCode = ref([]); 
// Define computed property to hold filtered array
const filteredQuestionByTerm = ref([]);
const hasFilteredTerm = ref(false);

watch(selectedSubjectCode, (val)=>{
    
    filteredQuestionByCode.value = val.questions
    
    questionTotalCoumt.value = 0


})

const myArray = [
    {
        name: 'myPrelim',
        term: 'prelim',
    },
    {
        name: 'myMidterm',
        term: 'mid-term',
    },
    {
        name: 'myPrelim',
        term: 'pre-final',
    },
    {
        name: 'myFinal',
        term: 'final',
    }
]


// Watcher for each checkbox
watch(prelim, updateFilteredArray);
watch(midTerm, updateFilteredArray);
watch(prefinal, updateFilteredArray);
watch(final, updateFilteredArray);

// Function to filter myArray based on checkbox values
function updateFilteredArray() {
        
        if(prelim.value || midTerm.value || prefinal.value || final.value)
        {
            

            filteredQuestionByTerm.value = filteredQuestionByCode.value.filter(item => {
                return (
                    (prelim.value && item.term === 'prelim') ||
                    (midTerm.value && item.term === 'mid-term') ||
                    (prefinal.value && item.term === 'pre-final') ||
                    (final.value && item.term === 'final')
                );
            });

            hasFilteredTerm.value = true; 
        }
        else
        {
            hasFilteredTerm.value = false;
            filteredQuestionByTerm.value = [];
        }
    
}


// Initial call to updateFilteredArray
updateFilteredArray();


const allTerm = ref(false);
const allTermsSelected = ref(false)
watch(allTerm,(val)=>{
        
        prelim.value = val
        midTerm.value = val
        prefinal.value = val
        final.value = val
        allTermsSelected.value = val
})
const questionTotalCoumt = ref('')
function getQuestionTotalCount(count){
    questionTotalCoumt.value = count
}

function getDisplayedQuestions(){
    return hasFilteredTerm.value ? filteredQuestionByTerm.value : filteredQuestionByCode.value
}

const textTab = ref(true)
const imageTab = ref(false)

function handleTabMenu(tab)
{
    
    if(tab === 'text')
    {
        
        textTab.value = true;
        imageTab.value = false;
    }
    
    if(tab === 'image')
    {
        imageTab.value = true
        textTab.value = false
    }
}


// sweet alert logic

const deleteConfirmation = (questionId)=> 
    { 
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            allowOutsideClick:false,
            allowEscapeKey:false,
            }).then((result) => {
                if(result.isConfirmed)
                {
                    const deleteUrl = route('questions.delete',{id: questionId })

                    router.delete(deleteUrl);
                }

                if(result.isDismissed)
                {
                    Swal.fire({
                        title:'Canceled',
                        text:'Your action was canceled!',
                        icon:'error',
                        confirmButtonColor: '#3085d6',
                    })
                }
        });
    }  

    function successMessage(message)
    {
        Swal.fire({
            title:'Success',
            text:message,
            icon:'success',
            allowOutsideClick:false,
            allowEscapeKey:false,
        }).then((result)=>{
            if(result.isConfirmed)
            {
                location.reload();
            }
        })
    }
    
    function errorMessage(message) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: message + '!',
            allowOutsideClick:false,
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        })
    }

    
</script>

