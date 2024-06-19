<template>
  <div>
    <div class="header">
      <h1 @click="handleButtonClick('')">{{ headerTitle }}</h1>
      <div class="button-group">
        <button v-for="(button, index) in buttons" :key="index" @click="handleButtonClick(button)">{{ button }}</button>
      </div>
    </div>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      headerTitle: 'Latest News',
      buttons: ['BiH', 'Nogomet', 'Crna hronika', 'Svijet', 'Showbiz'],
    };
  },
  mounted() {
  },
  methods: {
    handleButtonClick(category) {
      this.$emit('buttonClick', category);
      console.log(`Fetching news for category: ${category}`);
    }
  }
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #f0f0f0;
  margin-bottom: 50px;
}

.button-group button {
  margin-left: 10px;
}

</style>
