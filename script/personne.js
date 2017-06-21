var appListing = new Vue(
  {
    el: "#listing",
    data: {
      show: false,
      personnesL: {},
      the_personne: {}
    },
    mounted : function(){//mounted : l'application est prête à fonctionner
      this.getRequestAjax();//Avec this, on appelle l'objet appListing
    },
    methods: {
      //La requête ajax
      getRequestAjax : function() {
        let xhr = new XMLHttpRequest();
        let self = this;//On crèe la variable self qui va contenir le "this" à ce moment là, donc "appListing". Cela permet de l'utiliser plus tard.

        xhr.open('GET', 'listing.php?ajax', true);
        xhr.onreadystatechange = function () {
          if(xhr.readyState == 4 && xhr.status == 200) {
            self.personnesL = JSON.parse(xhr.responseText);
          }
        }
        xhr.send();
      },

      getSingle : function(e){
        e.preventDefault();
        //On récupère l'élément sur lequel on a cliqué avec e.target
        idp = e.target.getAttribute("data-idp");
        
        let xhr = new XMLHttpRequest();
        let self = this;
        this.show = false;

        xhr.open('GET', 'listing.php?ajax&id_personnes='+ idp +'', true);
        xhr.onreadystatechange = function() {
          if(xhr.readyState == 4 && xhr.status == 200) {
            personne = JSON.parse(xhr.responseText);
            self.the_personne = personne;
            self.show = true;
            //console.log(self.the_personne);
          }
        }
        xhr.send();
      }
    }
  }
);