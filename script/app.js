
var app = new Vue(
  {
    //el et date sont des propriétés de l'objet Vue
    //élément ciblé
    el: "#app",
    //scope
    data: {
      titre: "Titre de l'article",
      message: "Hello world"
    }
  }
);

var app2 = new Vue(
  {
    el: "#app2",
    data: {
      message: "Vous avez vu cette page le" + new Date()
    }
  }
)

var app3 = new Vue(
  {
    el: "#app3",
    data: {
      seen: true,
      message: "Je suis là"
    }
  }
)

var app4 = new Vue(
  {
    el: "#app4",
    data: {
      todos: [
        {text: "Manger", time: "12:00"},
        {text: "Boire", time: "14:00"},
        {text: "Dormir", time: "21:00"}
      ]
    }
  }
)

var app5 = new Vue(
  {
    el: "#app5",
    data: {
      message : "Message par défaut"
    }
  }
)
