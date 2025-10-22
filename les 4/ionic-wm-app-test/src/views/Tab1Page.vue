<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Tab 1 : Formulaire</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true" class="ion-padding">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Ajouter un produit</ion-title>
        </ion-toolbar>
      </ion-header>

      <ion-list>
        <ion-item>
          <ion-input label="Nom du produit" label-placement="floating" v-model="product.name"></ion-input>
        </ion-item>

        <ion-item>
          <ion-input label="Prix" label-placement="floating" type="number" v-model="product.price"></ion-input>
        </ion-item>

        <ion-radio-group v-model="product.category">
          <ion-list-header>
            <ion-label>Catégorie</ion-label>
          </ion-list-header>

          <ion-item>
            <ion-label>Fruit</ion-label>
            <ion-radio slot="start" value="Fruit"></ion-radio>
          </ion-item>

          <ion-item>
            <ion-label>Groente</ion-label>
            <ion-radio slot="start" value="Groente"></ion-radio>
          </ion-item>
        </ion-radio-group>
      </ion-list>
      
      <ion-button expand="block" @click="submitForm" class="ion-margin-top">Versturen</ion-button>

    </ion-content>
  </ion-page>
</template>

<script setup>
import { ref } from 'vue';
import { 
  IonPage, IonHeader, IonToolbar, IonTitle, IonContent, 
  IonList, IonListHeader, IonLabel, IonItem, IonInput, 
  IonRadioGroup, IonRadio, IonButton, alertController 
} from '@ionic/vue';

// On utilise ref pour que Vue suive les changements dans notre objet produit
const product = ref({
  name: '',
  price: null,
  category: 'Fruit' // Une valeur par défaut
});

// La fonction pour la soumission fictive
const submitForm = async () => {
  const alert = await alertController.create({
    header: 'Formulaire envoyé',
    message: `Le produit "${product.value.name}" a été ajouté (fictivement).`,
    buttons: ['OK'],
  });
  await alert.present();

  // On vide les champs après l'envoi
  product.value.name = '';
  product.value.price = null;
};
</script>