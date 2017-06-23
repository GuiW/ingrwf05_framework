//1. On définit nos composants (template)
const Foo = {
  template: "<div>Foo</div>"
};

const Bar = {
  template: "<div>Bar</div>"
};

const User = {
  //Le $ veut dire qu'on fait appelle au scope général
  //Le $route fait référence au query string de l'url
  template: "<div>User {{ $route.params.username }} a publié la publication n°{{ $route.params.publication }}</div>"
};

const Produit = {
  template: "<div>Produit {{ $route.params.idProduit }}</div>"
}


//2. On définit nos routes
const routes = [
  //Si on est sur foo, on appeler la constante Foo
  {path: "/foo", component: Foo},
  {path: "/bar", component: Bar},
  //Partie statique : user / Partie dynamique : id (avec le : devant)
  {path: "/user/:username/publication/:publication", component: User},
  //On donne le nom "poduit" au chemin. 
  {path: "/produit/:idProduit", name: "produit", component: Produit}
];


//3. On active le router
const router = new VueRouter({
  routes
});


//4. Création de l'app
const app = new Vue({
  el: "#app",
  //A l'activation de la vue, on déclenche le router
  router,
  data: {
    message: "Test"
  }
})