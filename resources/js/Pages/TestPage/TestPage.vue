<template>
  <div id="answers-pdf">
    <!-- Heading -->
    <div class="flex justify-center gap-2 w-full pb-2">
      <div class="flex justify-between gap-4">
        <div class="w-20 h-20 mt-[18px]">
          <img :src="logoUrl" alt="Ncst Logo"/>
        </div>
        <div class="flex flex-col justify-center items-center mb-2 mt-1">
          <span class="font-bold text-[18px]">NATIONAL COLLEGE OF SCIENCE AND TECHNOLOGY</span>
          <span>Amafel Building Aguinaldo Highway, Dasmariñas, Cavite</span>
          <span>Tel. no. (1234-1234)</span>
          <a href="https://ncst.edu.ph/" target="_blank">www.ncst.edu.ph</a>
          <span class="text-[16px] font-bold mt-2">CSD Department</span>
          <span class="text-[16px] font-bold"> </span>
          <span class="text-[16px] font-bold">2nd Semester SY: 2024-2025</span>
          <span class="text-[16px] font-bold">Set A</span>
        </div>
      </div> 
    </div>
    <!-- Grid -->
    <div class="grid pb-2" :class="`grid-cols-${columns}`" :style="{ gridTemplateColumns: `repeat(${columns}, minmax(0, 1fr))` }">
      <div v-for="(chunk, colIndex) in chunksToShow" :key="colIndex" class="col-span-1">
        <div v-for="(ans, index) in chunk" :key="index">
          <span >{{ index + 1 + colIndex * maxChunkSize }}. {{ ans }}</span>
        </div>
      </div>
    </div>
    
  </div>
  <!-- Button to download PDF -->
  <button class="btn-primary w-full mt-4" @click="downloadPDF">Download PDF</button>
</template>

<script setup>
import { ref, computed } from 'vue';
import html2pdf from 'html2pdf.js';

// Sample data
const testAnswers = [
    'a', 'b', 'c', 'd', 'd', 'b', 'c', 'd', 'a', 'a', 'b', 'b', 'a', 'b', 'c', 'd', 'd', 'b', 'c', 'd', 'a', 'a', 'b', 'b', 'a', 'b', 'c', 'd', 'd', 'b', 'c', 'd', 'a', 'a', 'b', 'b', 'a', 'b', 'c', 'd', 'd', 'b', 'c', 'd', 'a', 'a', 'b', 'b', 'a', 'b', 'c', 'd', 'd', 'b', 'c', 'd', 'a', 'a', 'b', 'b',
    
];
// Define the maximum number of elements to display per column
const maxChunkSize = 33;
const maxElementsPerColumn = 33 * 7; // 35 elements per column * 6 columns

// Helper function to chunk array
function chunkArray(arr, size) {
  const chunks = [];
  for (let i = 0; i < arr.length; i += size) {
    chunks.push(arr.slice(i, i + size));
  }
  return chunks;
}

// Split testAnswers into chunks of max 35 elements
const chunks = chunkArray(testAnswers, maxChunkSize);

// Calculate the number of columns based on the number of chunks
const columns = computed(() => Math.min(7, chunks.length));

// Determine how many chunks to display
const chunksToShow = computed(() => chunks.slice(0, Math.ceil(maxElementsPerColumn / maxChunkSize)));

var opt = {
  margin:       [0.1,0.4,0.2,0.4],
  filename:     'myfile.pdf',
  image:        { type: 'jpeg', quality: 0.98 },
  html2canvas:  { scale: 2 },
  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
};
// Method to download PDF
const downloadPDF = () => {
  const element = document.getElementById('answers-pdf');
  html2pdf().set(opt).from(element).save();
};

// Logo URL
const logoUrl = ref('/storage/Images/ncstLogo.png');

</script>

<style scoped>
.grid {
  gap: 1rem;
}
</style>
