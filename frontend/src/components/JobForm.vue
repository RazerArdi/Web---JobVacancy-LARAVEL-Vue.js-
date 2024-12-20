<!-- JobForm.vue -->
<template>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <DialogTitle as="h3" class="text-lg font-medium text-gray-900">
          {{ isEdit ? 'Edit Job' : 'Create New Job' }}
        </DialogTitle>
        <button @click="$emit('close')" class="text-gray-400 hover:text-gray-500">
          <XMarkIcon class="h-6 w-6" />
        </button>
      </div>
  
      <form @submit.prevent="submitForm" class="space-y-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input
              type="text"
              v-model="jobData.title"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700">Company</label>
            <input
              type="text"
              v-model="jobData.company"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700">Location</label>
            <input
              type="text"
              v-model="jobData.location"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700">Job Type</label>
            <select
              v-model="jobData.job_type"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
              <option value="Full-time">Full-time</option>
              <option value="Part-time">Part-time</option>
              <option value="Contract">Contract</option>
              <option value="Freelance">Freelance</option>
            </select>
          </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700">Minimum Salary</label>
            <input
              type="number"
              v-model="jobData.salary_min"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700">Maximum Salary</label>
            <input
              type="number"
              v-model="jobData.salary_max"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Description</label>
          <textarea
            v-model="jobData.description"
            rows="4"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          ></textarea>
        </div>
  
        <div>
  <label class="block text-sm font-medium text-gray-700">Requirements</label>
  <textarea
    v-model="jobData.requirements"
    rows="4"
    required
    placeholder="Enter requirements separated by commas or line breaks"
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
  ></textarea>
</div>

<div>
  <label class="block text-sm font-medium text-gray-700">Skills</label>
  <textarea
    v-model="jobData.skills"
    rows="4"
    required
    placeholder="Enter skills separated by commas or line breaks"
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
  ></textarea>
</div>

  
        <div>
          <label class="block text-sm font-medium text-gray-700">Application Deadline</label>
          <input
            type="date"
            v-model="jobData.application_deadline"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          />
        </div>
  
        <div class="flex justify-end space-x-3">
          <button
            type="button"
            @click="$emit('close')"
            class="inline-flex justify-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"
          >
            {{ isEdit ? 'Update Job' : 'Create Job' }}
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import { DialogTitle } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
  initialJob: {
    type: Object,
    default: () => ({
      title: '',
      description: '',
      company: '',
      location: '',
      salary_min: 0,
      salary_max: 0,
      job_type: 'Full-time',
      requirements: '',
      skills: '',
      application_deadline: ''
    })
  },
  isEdit: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['form-submitted', 'close']);
const jobData = ref({ ...props.initialJob });

      const submitForm = async () => {
          if (typeof jobData.value.requirements === 'string') {
              jobData.value.requirements = jobData.value.requirements
                  .split(/[\n,]/) // Split by newline or comma
                  .map((item) => item.trim())
                  .filter((item) => item !== ""); // Remove empty elements
          }

          if (typeof jobData.value.skills === 'string') {
              jobData.value.skills = jobData.value.skills
                  .split(/[\n,]/) // Split by newline or comma
                  .map((item) => item.trim())
                  .filter((item) => item !== "");
          }

          const url = props.isEdit
              ? `http://localhost:8000/api/job-listings/${jobData.value.id}`
              : 'http://localhost:8000/api/job-listings';
          const method = props.isEdit ? 'PUT' : 'POST';

          try {
              const response = await fetch(url, {
                  method,
                  headers: {
                      'Content-Type': 'application/json',
                  },
                  body: JSON.stringify(jobData.value),
              });

              const data = await response.json();

              if (data && data.id) {
                  toast.success(props.isEdit ? 'Job updated successfully!' : 'Job created successfully!');
                  emit('form-submitted');
              } else {
                  toast.error('Failed to submit job: ' + (data.message || 'Unknown error'));
              }
          } catch (error) {
              toast.error('There was an error submitting the job.');
          }
      };

</script>


<!-- Add styles for transitions and animations -->
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.3s ease-out;
}

.slide-up-enter-from {
  transform: translateY(20px);
  opacity: 0;
}

.slide-up-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>