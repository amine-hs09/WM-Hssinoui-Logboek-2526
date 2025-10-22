<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Tab 2 : Produits</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Liste des produits</ion-title>
        </ion-toolbar>
      </ion-header>

      <ion-searchbar v-model="searchTerm" placeholder="Chercher un produit..."></ion-searchbar>
      
      <ion-list>
        <ion-item v-for="product in filteredProducts" :key="product.id">
          <ion-label>
            <h2>{{ product.name }}</h2>
            <p>Prix: €{{ product.price }} | Catégorie: {{ product.category }}</p>
          </ion-label>
        </ion-item>
      </ion-list>

    </ion-content>
  </ion-page>
</template>

<script setup>
import { ref, computed } from 'vue';
import { 
  IonPage, IonHeader, IonToolbar, IonTitle, IonContent,
  IonSearchbar, IonList, IonItem, IonLabel
} from '@ionic/vue';

// Le ref pour stocker le texte de la recherche
const searchTerm = ref('');

// Une liste de produits statique pour l'exemple
const products = ref([
  { id: 1, name: 'Appel', price: 1.5, category: 'Fruit' },
  { id: 2, name: 'Banaan', price: 0.8, category: 'Fruit' },
  { id: 3, name: 'Wortel', price: 1.2, category: 'Groente' },
  { id: 4, name: 'Broccoli', price: 2.1, category: 'Groente' },
  { id: 5, name: 'Aardbei', price: 3.0, category: 'Fruit' }
]);

// C'est ici la magie : cette liste se met à jour automatiquement
// dès que 'searchTerm' change.
const filteredProducts = computed(() => {
  if (!searchTerm.value) {
    return products.value;
  }
  return products.value.filter(product =>
    product.name.toLowerCase().includes(searchTerm.value.toLowerCase())
  );
});
</script>