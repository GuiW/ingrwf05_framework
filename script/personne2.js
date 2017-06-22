var appListing = new Vue(
  {
    el: "#listing",
    data: {
      showSingle: false,
      showForm: false,
      personnesL: {},
      the_personne: {},
      form: {
        nom: "",
        prenom: "",
        email: "",
        telephone: "",
        ddn: "",
        genre: "",
        insert_personne: "",
        id_personnes: ""
      }
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
            //console.log(xhr.responseText);
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
        this.showSingle = false;

        xhr.open('GET', 'listing.php?ajax&id_personnes='+ idp +'', true);
        xhr.onreadystatechange = function() {
          if(xhr.readyState == 4 && xhr.status == 200) {
            personne = JSON.parse(xhr.responseText);
            self.the_personne = personne;
            self.showForm = false;
            self.showSingle = true;
            //console.log(self.the_personne);
          }
        }
        xhr.send();
      },

      onSubmit : function(){
        let self = this;
        
        array = [];
        for(property in this.form) {
          string = property + "=" + this.form[property];
          array.push(string);
        }
        arrayString = array.join("&");
        console.log(arrayString)

        //Requête ajax
        xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if(xhr.readyState == 4 && xhr.status == 200) {
            if(xhr.responseText != "pas ok") {

              self.form.id_personnes = xhr.responseText;
              self.personnesL.push(self.form);
              self.showForm = false
            }
            else {
              console.log("ERREUR")
            }
          }
        }

        xhr.open("POST", "listing.php?ajax", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(arrayString);
      }
    }
  }
);