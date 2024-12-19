<!-- JobList.vue -->
<template>
  <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <div v-for="job in jobs" :key="job.id" class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
      <div class="p-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">{{ job.title }}</h3>
          <span class="px-3 py-1 text-sm font-medium rounded-full" :class="getJobTypeClass(job.job_type)">
            {{ job.job_type }}
          </span>
        </div>

        <!-- Details -->
        <div class="space-y-2 mb-4">
          <div class="flex items-center text-gray-600">
            <BuildingOfficeIcon class="h-5 w-5 mr-2" />
            {{ job.company }}
          </div>
          <div class="flex items-center text-gray-600">
            <MapPinIcon class="h-5 w-5 mr-2" />
            {{ job.location }}
          </div>
          <div class="flex items-center text-gray-600">
            <CurrencyDollarIcon class="h-5 w-5 mr-2" />
            ${{ formatSalary(job.salary_min) }} - ${{ formatSalary(job.salary_max) }}
          </div>
        </div>

        <p class="text-gray-600 mb-4 line-clamp-3">{{ job.description }}</p>

        <div class="flex justify-end space-x-2">
          <button
            @click="editJob(job)"
            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
          >
            <PencilIcon class="h-4 w-4 mr-2" />
            Edit
          </button>
          <button
            @click="confirmDelete(job.id)"
            class="inline-flex items-center px-3 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50"
          >
            <TrashIcon class="h-4 w-4 mr-2" />
            Delete
          </button>
          <button
            @click="manageApplications(job)"
            class="inline-flex items-center px-3 py-2 border border-indigo-300 text-sm font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50"
          >
            Manage Applications
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { toast } from 'vue-sonner';
import { 
  BuildingOfficeIcon, 
  MapPinIcon, 
  CurrencyDollarIcon,
  PencilIcon,
  TrashIcon
} from '@heroicons/vue/24/outline';

// Declare emit to handle custom events
const emit = defineEmits();

// List of jobs
const jobs = ref([]);

const fetchJobs = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/job-listings');
    jobs.value = await response.json();
  } catch (error) {
    toast.error('Failed to fetch jobs');
  }
};

const confirmDelete = async (jobId) => {
  if (confirm('Are you sure you want to delete this job?')) {
    try {
      await fetch(`http://localhost:8000/api/job-listings/${jobId}`, {
        method: 'DELETE'
      });
      await fetchJobs();
      toast.success('Job deleted successfully');
    } catch (error) {
      toast.error('Failed to delete job');
    }
  }
};

const formatSalary = (salary) => {
  return new Intl.NumberFormat('en-US').format(salary);
};

const getJobTypeClass = (jobType) => {
  const classes = {
    'Full-time': 'bg-green-100 text-green-800',
    'Part-time': 'bg-blue-100 text-blue-800',
    'Contract': 'bg-purple-100 text-purple-800',
    'Freelance': 'bg-yellow-100 text-yellow-800',
  };
  return classes[jobType] || 'bg-gray-100 text-gray-800';
};

onMounted(fetchJobs);

// Function to trigger edit job event
const editJob = (job) => {
  emit('edit-job', job);
};

// Function to manage applications for a job
const manageApplications = (job) => {
  emit('manage-applications', job);  // Emit event to manage applications
};
</script>
