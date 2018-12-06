<template>
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Siswa</div>

                  <div class="panel-body">
                      I'm an example SiswaComponent!
                      <qrcode text="I'm an example SiswaComponent!"></qrcode>
                      <br>
                      <button @click="print" class="btn btn-primary">Print</button>
                  </div>
              </div>
          </div>
      </div>
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
  },
  methods: {
    print : () => {
      window.print()
    }
  }
};
</script>