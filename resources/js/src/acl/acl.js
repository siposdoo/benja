import Vue from 'vue'
import { AclInstaller, AclCreate, AclRule } from 'vue-acl'
import router from '@/router'

Vue.use(AclInstaller)

let initialRole = '8144a36f88b8c47153a0db9fb1619d101'

const userInfo = JSON.parse(localStorage.getItem('userInfo'))
if (userInfo && userInfo.userRole) initialRole = userInfo.userRole

export default new AclCreate({
  initial  : initialRole,
  notfound : '/pages/not-authorized',
  router,
  acceptLocalRules : true,
  globalRules: {
    admin  : new AclRule('a2eed3a65bb08aeff6857224776185d8').generate(),
    unosproizvoda  : new AclRule('b2eed3a65bb08aeff6857224776185d9').generate(),
    superadmin  : new AclRule('6be6eada56e0e523d15c30b23123d411').generate(),
    superadminidobavljac  : new AclRule('6be6eada56e0e523d15c30b23123d411').or('a2eed3a65bb08aeff6857224776185d8').generate(),
    sop  : new AclRule('8122a36f88b8c47153a0db9fb1619d10').generate(),
    sopidobavljac  : new AclRule('8122a36f88b8c47153a0db9fb1619d10').or('a2eed3a65bb08aeff6857224776185d8').generate(),
    public  : new AclRule('8144a36f88b8c47153a0db9fb1619d101').generate(),
    editor : new AclRule('8122a36f88b8c47153a0db9fb1619d10').or('6be6eada56e0e523d15c30b23123d411').or('a2eed3a65bb08aeff6857224776185d8').generate()
  }
})
