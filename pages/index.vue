<template lang="html">
  <section class="ui container">
    <h1>Email Microservice</h1>
    <form class="ui form">
      <div class="field">
        <label>Your Name</label>
        <input placeholder="Your name" v-model="name"/>
      </div>
      <div class="field">
        <label>Your Email</label>
        <input placeholder="Your email" v-model="email"/>
      </div>
      <div class="field">
        <label>Subject</label>
        <input placeholder="Subject" v-model="subject"/>
      </div>
      <div class="field">
        <label>Your Message</label>
        <textarea placeholder="Your message" v-model="message"></textarea>
      </div>
      <button @click.prevent="send" class="ui button" v-if="!needsMessage">Send!</button>
      <div class="ui icon message" v-if="needsMessage">
        <i class="notched circle loading icon" v-if="isSending"></i>
        <i class="thumbs down icon" v-if="isError"></i>
        <i class="thumbs up icon" v-if="isSuccess"></i>
        <div class="content">
          <div class="header">
            {{ feedbackHeader }}
          </div>
          <p>{{ feedbackMessage }}</p>
        </div>
      </div>
    </form>
  </section>
</template>

<script>
export default {
  data(){
    return {
      email: "",
      name: "",
      message: "",
      subject: "",
      isSending: false,
      isError: false,
      isSuccess: false,
      needsMessage: false,
      feedbackHeader: "",
      feedbackMessage: ""
    }
  },
  methods: {
    send(){
      if (this.email || this.name || this.message || this.subject){
        this.needsMessage = true;
        this.isSending = true;
        this.feedbackHeader = "Hang on...";
        this.feedbackMessage = "We're sending your message...";
        this.$axios.post("sender.php", {
          "email": this.email,
          "message": this.message,
          "subject": this.subject,
          "name": this.name
        }).then((res) => {
          if (res.data.success){
            this.isSending = false;
            this.isError = false;
            this.isSuccess = true;
            this.feedbackHeader = "Success";
            this.feedbackMessage = "Your message was successfully sent."
            this.reset();
          }
        }).catch((err) => {
          this.isSending = false;
          this.isError = true;
          this.isSuccess = false;
          this.feedbackHeader = "Error";
          this.feedbackMessage = err;
          this.reset();
        })
      }
    },
    reset(){
      setTimeout(() => {
        this.needsMessage = false;
        this.isSending = false;
        this.isError = false;
        this.isSuccess = false;
        this.feedbackHeader = "";
        this.feedbackMessage = "";
        this.email = "";
        this.name = "";
        this.message = "";
        this.subject = "";
      }, 1500)
    }
  }
}
</script>

<style lang="css">
</style>
