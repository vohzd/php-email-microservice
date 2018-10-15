module.exports = {
  head: {
    title: "Email Microservice",
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "Send emails to any email address without a mail client" }
    ],
    link: [
      { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
    ]
  },
  loading: { color: "#812747" },
  build: {
    extend(config, { isDev, isClient }){
      config.node = { fs: "empty", child_process: "empty" }
    }
  },
  modules: [
    "@nuxtjs/axios",
    'semantic-ui-vue/nuxt'
  ],
  axios: {
    baseURL: "/",
    proxyHeaders: false,
    credentials: true
  }
}
