import { defineStore } from "pinia";

export const useAuthStore = defineStore("authStore", {
  state: () => {
    return {
      user: null,
      surname: "kanzariya",
      errors: {},
      custom_error: "",
    };
  },
  getters: {
    userName: (state) => state.user,
  },
  actions: {
    async authenticateUser(apiRoute, formData) {
      const res = await fetch(`/api/${apiRoute}`, {
        method: "POST",
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      if (data.errors) {
        this.errors = data.errors;
      } else {
        this.router.push({ name: "home" });
      }
    },
    async userLogin(apiRoute, formData) {
      const res = await fetch(`/api/${apiRoute}`, {
        method: "POST",
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      if (data.errors) {
        this.errors = data.errors;
      } else if (data.status == "error") {
        this.custom_error = data.message;
      } else {
        localStorage.setItem("token", data.data.token);
        this.router.push({ name: "home" });
      }
    },
    async logoutUser() {
      let apiRoute = "logout";
      const res = await fetch(`/api/${apiRoute}`, {
        method: "POST",
        headers: {
          authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      const data = await res.json();
      if (data.status == "success") {
        this.user = null;
        this.errors = {};
        localStorage.removeItem("token");
        this.router.push({ name: "login" });
      }
    },
    async getUser() {
      if (localStorage.getItem("token")) {
        const res = await fetch("/api/show", {
          method: "POST",
          headers: {
            authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });
        const data = await res.json();
        if (data.status == "success") {
          this.user = data.data;
        }
      } else {
        this.user = null;
      }
    },
  },
});
