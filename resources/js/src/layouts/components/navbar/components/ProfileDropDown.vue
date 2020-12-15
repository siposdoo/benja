<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.displayName">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.displayName }}</p>
      <small  v-if="activeUserInfo.userRole==='a2eed3a65bb08aeff6857224776185d8'">Dobavljač</small>
      <small  v-if="activeUserInfo.userRole==='6be6eada56e0e523d15c30b23123d411'">Superadmin</small>
      <small  v-if="activeUserInfo.userRole==='8122a36f88b8c47153a0db9fb1619d10'">Šop</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="con-img ml-3">
        <img v-if="activeUserInfo.photoURL" key="onlineImg" :src="activeUserInfo.photoURL" alt="user-img" width="40" height="40" class="rounded-full shadow-md cursor-pointer block" />
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">

          <!--li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/pages/profile').catch(() => {})">
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Profile</span>
          </li>

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/apps/email').catch(() => {})">
            <feather-icon icon="MailIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Inbox</span>
          </li>

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/apps/todo').catch(() => {})">
            <feather-icon icon="CheckSquareIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Tasks</span>
          </li>

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/apps/chat').catch(() => {})">
            <feather-icon icon="MessageSquareIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Chat</span>
          </li>

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/apps/eCommerce/wish-list').catch(() => {})">
            <feather-icon icon="HeartIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Wish List</span>
          </li-->

          <vs-divider class="m-1" />

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Logout</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>
 
 
export default {
  data () {
    return {

    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
    logout () {

      
      // If JWT login
      if (localStorage.getItem('accessToken')) {
         this.$acl.change('8144a36f88b8c47153a0db9fb1619d101')
      localStorage.removeItem('userInfo')
        localStorage.removeItem('accessToken')
        this.$router.push('/pages/login').catch(() => {})
      }

      // Change role on logout. Same value as initialRole of acj.js
      this.$acl.change('8144a36f88b8c47153a0db9fb1619d101')
      localStorage.removeItem('userInfo')

      // This is just for demo Purpose. If user clicks on logout -> redirect
      this.$router.push('/pages/login').catch(() => {})
    }
  }
}
</script>
