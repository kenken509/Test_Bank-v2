<template>

    <DashboardLayout>
        <!--users count-->
        <div class="flex items-center justify-between border-bot-only py-2 mb-4">
            <span class="text-[20px] font-bold text-gray-500">Dashboard </span> 
            
        </div>
        <div class="flex h-full w-full justify-center items-center mt-8"> 
            <div class="w-full flex justify-between gap-2">
                <div class="w-full flex flex-col  gap-2 border border-gray-500 rounded-md p-4 shadow-md bg-blue-100">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-users"></i>
                        <span>Admins</span>
                    </div>
                    <span class="text-[30px] font-semibold mt-4">{{ adminsCount }}</span>
                </div>
                <div class="w-full flex flex-col  gap-2 border border-gray-500 rounded-md p-4 shadow-md bg-blue-100">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-users"></i>
                        <span>Department Heads</span>
                    </div>
                    <span class="text-[30px] font-semibold mt-4">{{ depHeadCount }}</span>
                </div>
                <div class="w-full flex flex-col  gap-2 border border-gray-500 rounded-md p-4 shadow-md bg-blue-100">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-users"></i>
                        <span>Faculty</span>
                    </div>
                    <span class="text-[30px] font-semibold mt-4">{{ facultyCount }}</span>
                </div>
                <div class="w-full flex flex-col  gap-2 border border-gray-500 rounded-md p-4 shadow-md bg-blue-100">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-question-circle"></i>
                        <span>Questions</span>
                    </div>
                    <span class="text-[30px] font-semibold mt-4">{{ questionsCount }}</span>
                </div>
            </div>
        </div>
        <!--users count-->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10">
            <div class="w-full flex justify-center border rounded-t-md bg-blue-900 border-gray-500 text-gray-800">
                <span class="text-[20px] font-semibold text-white p-1">LOWEST CONTRIBUTIONS</span>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-200 uppercase bg-blue-900 dark:bg-gray-700 dark:text-gray-400">
                    <tr scope="row">
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">User</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">No.Questions</th>
                    </tr>
                </thead>
                <tbody v-for="(user,index) in userQuestionCount" :key="index">
                    <tr scope="row">
                        <td scope="col" class="px-6 py-3 text-gray-800">
                            {{ index+1 }}
                        </td>
                        <td scope="col" class="px-6 py-3 text-gray-800">
                            {{ user.name }} 
                        </td>
                        <td scope="col" class="px-6 py-3 text-gray-800">
                           {{ user.email }}
                        </td>
                        <td scope="col" class="px-6 py-3 text-gray-800">
                           {{ user.role }}
                        </td>
                        <td scope="col" class="px-6 py-3 text-gray-800">
                            {{ user.questions_count }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../DashboardLayout.vue';

const data = defineProps({
    adminsCount:Number,
    depHeadCount:Number,
    facultyCount:Number,
    questionsCount:Number,
    userQuestionCount:Array,
})

</script>
