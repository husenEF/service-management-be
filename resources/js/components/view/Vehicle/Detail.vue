<template>
  <div class="card">
    <div class="card-header">
      <h2>Detail Kendaraan</h2>
    </div>
    <div class="card-body">
      <!-- <pre>{{vehicle}}</pre> -->
      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr>
              <th>Merek Kendaraan</th>
              <td>{{vehicle.merek}}</td>
            </tr>
            <tr>
              <th>Plat Nomor</th>
              <td>{{vehicle.platnumber}}</td>
            </tr>
            <tr>
              <th>Data di buat Oleh</th>
              <td>{{vehicle.create_user.name}} ({{vehicle.create_user.roles}})</td>
            </tr>
            <tr>
              <th>Terakhir memperbaharui</th>
              <td>{{vehicle.update_by}}</td>
            </tr>
            <!-- <tr>
              <th colspan="2">Daftar Ban ({{vehicle.size}}")</th>
            </tr> -->
          </tbody>
        </table>

        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th colspan="3">Daftar Ban</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(t,i) in vehicle.tire" :key="i">
              <th>{{t.merek}}</th>
              <td>
                <p>
                  <strong>Tangal Pembelian</strong>
                  : {{t.buy_date}}
                  <br>
                  <strong>Gambar</strong>
                  :
                  <a
                    :href="t.images_path"
                    target="_blank"
                    rel="noopener noreferrer"
                  >Link</a>
                  <br>
                  <strong>Penginput Data</strong>
                  : {{t.user.name}} {{t.user.roles}}
                </p>
              </td>
              <td>
                <router-link
                  :to="'/ban/service/'+t.id"
                  class="btn btn-primary btn-sm"
                >Tambah Hasil Uji</router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "vehicleDetail",
  data() {
    return {
      vehicle: {}
    };
  },
  created() {
    const id = this.$route.params.id;
    this.getData(id);
    this.$emit("back", "/vehicle");
  },
  methods: {
    getData(id) {
      axios.get("/api/v1/vehicle/" + id).then(res => {
        const { data } = res;
        if (data.success) {
          this.vehicle = data.data;
          this.vehicle.tirescount = Object.keys(data.data.tires).length;
        }
      });
    }
  }
};
</script>