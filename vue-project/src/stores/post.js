import { defineStore } from "pinia";

export const usePostStore = defineStore("postStore", {
  state: () => {
    return {
      posts: [],
      post: {},
      errors: {},
    };
  },
  getters: {
    allPosts: (state) => state.posts,
    singlePost: (state) => state.post,
  },
  actions: {
    async fetchPosts() {
      const res = await fetch("api/posts", {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      const data = await res.json();
      this.posts = data.data;
    },
    async getPost(post) {
      const res = await fetch(`/api/posts/${post}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      const data = await res.json();
      console.log(data.data);
      
      return data.data;
    },
    async createPost(formData) {
      const res = await fetch("/api/posts", {
        method: "POST",
        body: JSON.stringify(formData),
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      const data = await res.json();
      if (data.errors) {
        this.errors = data.errors;
      } else {
        this.router.push({ name: "home" });
      }
    },
    async updatePost(id, formData) {
      const res = await fetch(`/api/posts/${id}`, {
        method: "PUT",
        body: JSON.stringify(formData),
      });
      const data = await res.json();
      if (data.errors) {
        this.errors = data.errors;
      } else {
        this.router.push({ name: "home" });
      }
    },
    async deletePost(id) {
      const res = await fetch(`/api/posts/${id}`, {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      const data = await res.json();
      if (data.status == "success") {
        this.router.push({ name: "home" });
      }
    },
  },
});
