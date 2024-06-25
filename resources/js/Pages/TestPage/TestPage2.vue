<template>
    <div>
      <input v-model="password" placeholder="Enter new password" />
      <button @click="validate">Validate Password</button>
      <p>{{ validationMessage }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const password = ref('');
  const validationMessage = ref('');
  
  const validate = () => {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    const result = regex.test(password.value);
    validationMessage.value = result ? 'Password is valid' : 'Password is invalid';
    console.log('Validating password:', password.value, 'Result:', result);
  };
  </script>