<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <h1 class="text-xl font-bold text-gray-900">Job Board</h1>
          <button
            @click="createJob"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
          >
            <PlusIcon class="h-5 w-5 mr-2" />
            Post New Job
          </button>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <!-- Job Form Modal -->
      <TransitionRoot appear :show="showForm" as="template">
        <Dialog as="div" @close="showForm = false" class="relative z-10">
          <!-- Background overlay and modal content -->
          <div class="fixed inset-0 bg-black bg-opacity-25" />
          <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
              <TransitionChild
                enter="ease-out duration-300"
                enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100"
                leave="ease-in duration-200"
                leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95"
              >
                <DialogPanel class="w-full max-w-2xl transform bg-white p-6 rounded-xl shadow-xl transition-all">
                  <JobForm 
                    :initial-job="selectedJob" 
                    :is-edit="isEdit" 
                    @form-submitted="handleFormSubmitted"
                    @close="showForm = false"
                  />
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>

      <!-- Job List -->
      <JobList 
        ref="jobList"
        @edit-job="editJob" 
        @create-job="createJob" 
      />
      <Toaster position="top-right" />
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import { Toaster } from 'vue-sonner';
import JobList from './components/JobList.vue';
import JobForm from './components/JobForm.vue';

const showForm = ref(false);  // Modal control state
const selectedJob = ref(null);  // Data job yang dipilih untuk diedit
const isEdit = ref(false);  // Untuk membedakan mode edit dan create

// Fungsi untuk membuka form dalam mode edit
const editJob = (job) => {
  selectedJob.value = job;  // Menyimpan job yang dipilih
  isEdit.value = true;  // Set mode edit
  showForm.value = true;  // Tampilkan modal
};

// Fungsi untuk membuka form dalam mode create
const createJob = () => {
  selectedJob.value = null;  // Reset data job
  isEdit.value = false;  // Set mode create
  showForm.value = true;  // Tampilkan modal
};

// Fungsi untuk menangani form yang sudah disubmit
const handleFormSubmitted = () => {
  showForm.value = false;  // Menutup modal setelah form disubmit
  // Melakukan PUT atau POST request ke server untuk update atau create job
};
</script>
