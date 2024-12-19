<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
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
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 flex-grow">
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
        @manage-applications="showManageApplications"  
      />

      <!-- Manage Applications Modal -->
      <TransitionRoot appear :show="showManage" as="template">
        <Dialog as="div" @close="showManage = false" class="relative z-10">
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
                  <ManageApplications
                    :job="selectedJob"
                    @close="showManage = false"
                  />
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>

      <Toaster position="top-right" />
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-auto">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200 pt-6">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-900">About</h3>
              <ul class="space-y-2">
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Company</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Careers</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Blog</a>
                </li>
              </ul>
            </div>
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-900">Support</h3>
              <ul class="space-y-2">
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Help Center</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Contact Us</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">FAQs</a>
                </li>
              </ul>
            </div>
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-900">Legal</h3>
              <ul class="space-y-2">
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Terms of Service</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Cookie Policy</a>
                </li>
              </ul>
            </div>
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-900">Connect</h3>
              <div class="flex space-x-4">
                <a href="#" class="text-gray-400 hover:text-gray-900">
                  <span class="sr-only">Facebook</span>
                  <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                  </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-900">
                  <span class="sr-only">Twitter</span>
                  <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                  </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-900">
                  <span class="sr-only">LinkedIn</span>
                  <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
          <div class="mt-8 border-t border-gray-200 pt-8">
            <p class="text-sm text-gray-500">&copy; 2024 Job Board. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import { Toaster } from 'vue-sonner';
import JobList from './components/JobList.vue';
import JobForm from './components/JobForm.vue';
import ManageApplications from './components/ManageApplications.vue';

const showForm = ref(false);
const showManage = ref(false);
const selectedJob = ref(null);
const isEdit = ref(false);

const editJob = (job) => {
  selectedJob.value = job;
  isEdit.value = true;
  showForm.value = true;
};

const createJob = () => {
  selectedJob.value = null;
  isEdit.value = false;
  showForm.value = true;
};

const handleFormSubmitted = () => {
  showForm.value = false;
};

const showManageApplications = (job) => {
  selectedJob.value = job;
  showManage.value = true;
};

</script>