import DashboardComponent from "./components/DashboardComponent";
import PetugasComponent from "./components/PetugasComponent";
import SiswaComponent from "./components/SiswaComponent";
import VueQRCodeComponent from "vue-qrcode-component";

const routes = [
  {
    name: "dashboard",
    path: "/",
    component: DashboardComponent
  },
  {
    name: "petugas",
    path: "/petugas",
    component: PetugasComponent
  },
  {
    name: "siswa",
    path: "/siswa",
    component: SiswaComponent
  }
];

export default routes;
