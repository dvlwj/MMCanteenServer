<template>
  <div class="panel-body">I'm an example SiswaComponent!
    <qrcode text="I'm an example SiswaComponent!" size="100"></qrcode>
  </div>
</template>

<script>
import qrcode from "./QRCode";
export default {
  name: "Siswa",
  mounted() {
    console.log("SiswaComponent mounted.");
  },
  components: {
    qrcode
  }
};
</script>
