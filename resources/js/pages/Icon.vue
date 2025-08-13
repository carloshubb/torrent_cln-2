<template>
  <div class="app">
    <div class="demo-section">
      <h3>Icon Buttons</h3>
      
      <!-- Icon Container -->
      <div class="icon-container">
        <button 
          v-for="icon in iconList" 
          :key="icon.type"
          :class="['icon-btn', `flaticon-${icon.type}`, { 'active': activeIcons.includes(icon.type) }]"
          @click="toggleIcon(icon.type)"
        >
          {{ icon.label }}
        </button>
      </div>
      
      <!-- Show active filters -->
      <div v-if="activeIcons.length > 0" class="active-filters">
        <p>Active Filters: {{ activeIcons.join(', ') }}</p>
        <button @click="clearAll" class="clear-btn">Clear All</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'IconButtonDemo',
  data() {
    return {
      iconList: [
        { type: 'anime', label: 'Anime' },
        { type: 'audio', label: 'Dual Audio' },
        { type: 'dubbed', label: 'Dubbed' },
        { type: 'raw', label: 'Raw' },
        { type: 'subbed', label: 'Subbed' }
      ],
      activeIcons: []
    }
  },
  methods: {
    toggleIcon(iconType) {
      const index = this.activeIcons.indexOf(iconType);
      if (index > -1) {
        this.activeIcons.splice(index, 1);
      } else {
        this.activeIcons.push(iconType);
      }
      console.log('Toggled:', iconType, 'Active icons:', this.activeIcons);
    },
    clearAll() {
      this.activeIcons = [];
      console.log('Cleared all filters');
    }
  }
}
</script>

<style scoped>
.app {
  background: #2c2c2c;
  min-height: 100vh;
  padding: 20px;
  font-family: Arial, sans-serif;
}

.demo-section {
  background: rgba(255,255,255,0.1);
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.demo-section h3 {
  color: white;
  margin-top: 0;
  margin-bottom: 20px;
}

.icon-container {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.icon-btn {
  background: linear-gradient(135deg, #ff6b35, #f7931e);
  color: white;
  border: none;
  border-radius: 8px;
  padding: 8px 16px;
  font-size: 12px;
  font-weight: bold;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.3);
  transition: all 0.2s ease;
  min-height: 32px;
}

.icon-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.4);
}

.icon-btn:active {
  transform: translateY(0);
}

.icon-btn.active {
  background: linear-gradient(135deg, #28a745, #20c997);
  transform: translateY(-1px);
}

/* Icon styles using pseudo-elements */
.flaticon-anime::before {
  content: "👤";
  font-size: 14px;
  margin-right: 4px;
}

.flaticon-audio::before {
  content: "🔊";
  font-size: 14px;
  margin-right: 4px;
}

.flaticon-dubbed::before {
  content: "🎬";
  font-size: 14px;
  margin-right: 4px;
}

.flaticon-raw::before {
  content: "📹";
  font-size: 14px;
  margin-right: 4px;
}

.flaticon-subbed::before {
  content: "💬";
  font-size: 14px;
  margin-right: 4px;
}

.active-filters {
  background: rgba(255,255,255,0.1);
  padding: 15px;
  border-radius: 4px;
  color: white;
}

.active-filters p {
  margin: 0 0 10px 0;
  color: #fff;
}

.clear-btn {
  background: #dc3545;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
  font-weight: bold;
  transition: background 0.2s ease;
}

.clear-btn:hover {
  background: #c82333;
}

/* Responsive design */
@media (max-width: 768px) {
  .icon-container {
    gap: 8px;
  }
  
  .icon-btn {
    padding: 6px 12px;
    font-size: 11px;
  }
}
</style>