 
export default [ 
  // {
  //   url: "/apps/email",
  //   name: "Email",
  //   slug: "email",
  //   icon: "MailIcon",
  //   i18n: "Email",
  // },
  {
    url:'/' ,
    name: 'Dashboard',
    tagColor: 'warning',
    icon: 'HomeIcon',
    i18n: 'Početna',
    
  },
   
  {
    header: 'Apps',
    icon: 'PackageIcon',
    i18n: '_',
    items: [
      
      {
         
       
        url: '/dobavljaci',
        name: 'Dobavljaci',
        icon: 'ShoppingBagIcon',
        i18n: 'Dobavljači',
        
      },
      {
         
       
        url: '/',
        name: 'Početna',
        icon: 'HomeIcon',
        i18n: 'Početna',
        
      },
      {
        url: '/nalozi',
        name: 'Nalozi',
        icon: 'MapIcon',
        slug: 'nalozi',
        i18n: 'Nalozi'
      },
      {
         
       
        url: '/unosproizvoda',
        name: 'Unos proizvoda',
        icon: 'StarIcon',
        i18n: 'Kompanije',
        
      },
      {
         
       
        url: '/sopovi',
        name: 'Sopovi',
        icon: 'ShoppingCartIcon',
        i18n: 'Šopovi',
        
      },
      {
         
       
        url: '/narudzbe',
        name: 'Narudzbe',
        icon: 'PackageIcon',
        i18n: 'Narudžbe',
        
      },
      {
         
       
        url: '/reklamacije',
        name: 'Reklamacije',
        icon: 'AlertOctagonIcon',
        i18n: 'Reklamacije',
        
      }
      
    ]
  },
  {
    header: 'FIRMA',
    icon: 'ListIcon',
    i18n: 'FIRMA',
    name: 'FIRMA',
    
 
    items: [
      {
        url: '/vozaci',
        name: 'Vozači',
        icon: 'UserIcon',
        tagColor: 'primary',
        i18n: 'Vozači',
      },
      {
        url: '/kamioni',
        name: 'Kamioni',
        icon: 'ListIcon',
        slug: 'kamioni',
        i18n: 'Kamioni'
      },{
        url: '/prikolice',
        name: 'Prikolice',
        icon: 'ListIcon',
        slug: 'prikolice',
        i18n: 'Prikolice'
      }
      ,{
        url: '/izvjetaji',
        name: 'Izvjestaji',
        icon: 'ListIcon',
        slug: 'izvjestaji',
        i18n: 'Izvjestaji'
      }
    ]
  },
  
]

