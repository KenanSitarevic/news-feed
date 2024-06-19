<template>
  <Header @buttonClick="GetNewsByCategory" />
  <div class="news-container">
    <div @click="goToLink(item.link)" v-for="(item, index) in news" :key="index" class="news-card">
      <img :src="item.image" alt="News Image" class="news-image">
      <div class="news-details">
        <h2 class="news-title">{{ item.title }}</h2>
        <p class="news-description">{{ item.description }}</p>
        <p class="news-pub-date">{{ formatDate(item.pubDate) }}</p>
        <p class="news-category">{{ item.category }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
  import axios from "axios";
  import { onMounted, ref } from "vue";
  import Header from '../components/Header.vue';

  const news = ref();

  const getNews = async () => {
      try {
          const response = await axios.get("/api/news");
          news.value = response.data.data;
      } catch (error) {
          // Do something with the error
          console.log(error);
      }
  };

  const goToLink = (link) => {
    location.href = link;
  }

  const GetNewsByCategory = async (category) => {
      try {
          if (category == '') getNews()
          else {
            const response = await axios.get(`/api/news/${category}`);
            news.value = response.data.data;
          }
          
      } catch (error) {
          // Do something with the error
          console.log(error);
      }
  };

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString(); // Adjust date formatting as needed
  }

onMounted(() => {
  getNews();
})
</script>

<style scoped>
.news-container {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  gap: 20px;
}

.news-card {
  cursor: pointer;
  border: 1px solid #ccc;
  border-radius: 8px;
  overflow: hidden;
  width: 300px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.news-image {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.news-details {
  padding: 16px;
}

.news-title {
  font-weight: 700;
  margin-top: 0;
  margin-bottom: 1em;
}

.news-pub-date {
  font-style: italic;
  margin-bottom: 8px;
}

.news-category {
  font-weight: bold;
  color: #333;
}
</style>