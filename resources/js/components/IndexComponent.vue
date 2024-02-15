<template>
    <div class="search-app">
        <div class="search-bar">
            <input v-model="searchTerm" @input="handleSearch" placeholder="Search the news..." />
        </div>

        <div class="search-results" v-if="results.length">
            <div v-for="result in results" :key="result.id" class="search-result">
                <h3 class="result-title">{{ result.webTitle }}</h3>
                <p class="result-section">Section: {{ result.sectionName }}</p>
                <p class="result-date">Date: {{ new Date(result.webPublicationDate).toLocaleDateString('en-GB') }}</p>
                <a :href="result.webUrl" target="_blank" rel="noopener noreferrer" class="result-link">Read more</a>
                <button @click="handlePin(result)" class="result-pin">Pin</button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const searchTerm = ref('');
    const results = ref([]);
    const pinnedItems = ref([]);

    const handleSearch = async () => {
      try {
        const response = await axios.post('/api/search', {
          searchTerm: searchTerm.value,
        });
        results.value = response.data;
      } catch (error) {
        console.error(error);
      }
    };

    const handlePin = (item) => {
      if (!pinnedItems.value.includes(item)) {
        pinnedItems.value.push(item);
      }
    };

    return {
      searchTerm,
      results,
      pinnedItems,
      handleSearch,
      handlePin,
    };
  },
};
</script>

<style scoped>
.search-app {
  max-width: 600px;
  margin: 50px auto;
  font-family: Arial, sans-serif;
}

.search-bar {
  background-color: #f2f2f2;
  padding: 10px;
  border-radius: 8px;
}

input {
  width: 100%;
  padding: 8px;
  font-size: 16px;
  border: none;
  outline: none;
  border-radius: 4px;
}

.search-results {
  margin-top: 20px;
}

.search-result {
  border: 1px solid #ddd;
  padding: 15px;
  margin-bottom: 15px;
  border-radius: 8px;
}

.result-title {
  font-size: 18px;
  margin-bottom: 10px;
}

.result-section, .result-date {
  color: #666;
}

.result-link {
  color: #4285f4;
  text-decoration: none;
  margin-right: 10px;
}

.result-pin {
  background-color: #4285f4;
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 4px;
  cursor: pointer;
}
</style>