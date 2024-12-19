<template>
    <div v-if="job">
      <h2>{{ job.title }}</h2>
      <p>{{ job.description }}</p>
      <p>Company: {{ job.company }}</p>
      <p>Location: {{ job.location }}</p>
      <p>Salary: {{ job.salary_min }} - {{ job.salary_max }}</p>
      <button @click="deleteJob">Delete</button>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      job: {
        type: Object,
        required: true
      }
    },
    methods: {
      deleteJob() {
        if (confirm('Are you sure you want to delete this job?')) {
          fetch(`http://localhost:8000/api/job-listings/${this.job.id}`, {
            method: 'DELETE'
          })
            .then(() => this.$emit('job-deleted'))
            .catch(error => console.error('Error:', error));
        }
      }
    }
  };
  </script>
  