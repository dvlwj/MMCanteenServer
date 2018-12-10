import DashboardComponent from "./components/DashboardComponent";
import PetugasComponent from "./components/PetugasComponent";
import SiswaComponent from "./components/SiswaComponent";
import LoginComponent from "./components/LoginComponent";
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
  },
  {
    name: "login",
    path: "/login",
    component: LoginComponent
  }
];

export default routes;
