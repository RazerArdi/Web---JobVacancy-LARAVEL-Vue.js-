<template>
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
          Applications for {{ job.title }}
        </h2>
        <button
          @click="$emit('close')"
          class="text-gray-500 hover:text-gray-700 transition-colors"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
  
      <div v-if="applications.length > 0" class="space-y-4">
        <div
          v-for="application in applications"
          :key="application.id"
          class="bg-gray-50 rounded-lg p-4 transition-all hover:shadow-md"
        >
          <div class="flex justify-between items-start">
            <div class="space-y-2">
              <h3 class="text-lg font-medium text-gray-900">
                {{ application.applicant_name }}
              </h3>
              <p class="text-gray-600 flex items-center">
                <svg
                  class="w-4 h-4 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                  />
                </svg>
                {{ application.email }}
              </p>
            </div>
            <button
              @click="deleteApplication(application.id)"
              class="text-red-500 hover:text-red-700 transition-colors p-2 rounded-full hover:bg-red-50"
            >
              <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
  
      <div
        v-else
        class="text-center py-12 bg-gray-50 rounded-lg"
      >
        <svg
          class="mx-auto h-12 w-12 text-gray-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
          />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">No applications yet</h3>
        <p class="mt-1 text-gray-500">Applications will appear here once received.</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { toast } from 'vue-sonner';
  
  const props = defineProps({
    job: Object
  });
  
  const applications = ref([]);
  
  const fetchApplications = async () => {
    try {
      const response = await fetch(`http://localhost:8000/api/job-listings/${props.job.id}/applications`);
      applications.value = await response.json();
    } catch (error) {
      toast.error('Failed to fetch applications');
    }
  };
  
  const deleteApplication = async (applicationId) => {
    if (confirm('Are you sure you want to delete this application?')) {
      try {
        await fetch(`http://localhost:8000/api/job-listings/${props.job.id}/applications/${applicationId}`, {
          method: 'DELETE'
        });
        await fetchApplications();
        toast.success('Application deleted successfully');
      } catch (error) {
        toast.error('Failed to delete application');
      }
    }
  };
  
  onMounted(fetchApplications);
  </script>