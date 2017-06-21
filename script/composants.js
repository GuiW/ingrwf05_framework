//On crèe un composant, on lui donne un nom "list-item"
Vue.component('list-item', {
  props: ['item'],
  template: "<li>{{ item.text }}</li>"
})

var app = new Vue(
  {
    el: "#app",
    data: {
      fruits: [
        {id:1, text:"<strong>Pommes</strong>"},
        {id:2, text:"Poires"},
        {id:3, text:"Abricots"}
      ],
      content: "<strong>Texte en gras</strong> et c'est tout"
    },
    //Avec created, toute l'application générale doit être créée
    created : function(){
      console.log(this.fruits);
    }
  }
)

var app2 = new Vue(
  {
    el: "#app2",
    data: {
      legumes: [
        {id:1, text:"Patates"},
        {id:2, text:"Carottes"},
        {id:3, text:"Chicons"}
      ]
    }
  }
)