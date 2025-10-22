<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Tab 3 : Équipe 7</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true" class="ion-padding">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Shinobi de Konoha</ion-title>
        </ion-toolbar>
      </ion-header>

      <ion-list>
        <ion-list-header>
          <ion-label>Membres de l'Équipe 7</ion-label>
        </ion-list-header>

        <ion-item>
          <ion-avatar aria-hidden="true" slot="start">
            <img alt="Naruto" src="https://ionicframework.com/docs/img/demos/avatar.svg" />
          </ion-avatar>
          <ion-label>
            <h2>Uzumaki Naruto</h2>
            <p>Le futur Hokage ! Dattebayo !</p>
          </ion-label>
        </ion-item>

        <ion-item>
          <ion-avatar aria-hidden="true" slot="start">
            <img alt="Sasuke" src="https://ionicframework.com/docs/img/demos/avatar.svg" />
          </ion-avatar>
          <ion-label>
            <h2>Uchiha Sasuke</h2>
            <p>Le dernier de son clan.</p>
          </ion-label>
        </ion-item>

        <ion-item>
          <ion-avatar aria-hidden="true" slot="start">
            <img alt="Sakura" src="https://ionicframework.com/docs/img/demos/avatar.svg" />
          </ion-avatar>
          <ion-label>
            <h2>Haruno Sakura</h2>
            <p>Disciple de la légendaire Tsunade.</p>
          </ion-label>
        </ion-item>
        
        <ion-item>
          <ion-avatar aria-hidden="true" slot="start">
            <img alt="Kakashi" src="https://ionicframework.com/docs/img/demos/avatar.svg" />
          </ion-avatar>
          <ion-label>
            <h2>Hatake Kakashi</h2>
            <p>Le ninja copieur au Sharingan.</p>
          </ion-label>
        </ion-item>
      </ion-list>

    </ion-content>
  </ion-page>
</template>

<script setup>
// On s'assure d'importer tous les composants qu'on utilise dans le template
import { 
  IonPage, IonHeader, IonToolbar, IonTitle, IonContent,
  IonList, IonListHeader, IonItem, IonLabel, IonAvatar
} from '@ionic/vue';
</script>