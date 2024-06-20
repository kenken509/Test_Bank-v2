<template>
    <DashboardLayout>
        <div class="flex items-center justify-between border-bot-only py-2 mb-4">
            <span class="text-[20px] font-bold text-gray-500">Announcements </span> 
        </div>
        <div>
            announcement table
            {{ data.announcements }}
        </div>
    </DashboardLayout>
    
</template>
<script setup>
import {ref} from 'vue'
import DashboardLayout from '../DashboardLayout.vue';

const data = defineProps({
    announcements:Array,
})

</script>