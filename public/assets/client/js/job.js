
$(document).ready(function () {
    $("#major-select").on('change', function () {
        Livewire.dispatch('updatedMajor', {
            major: this.value
        });
    })
    $("#perpage-select").on('change', function () {
        Livewire.dispatch('updatedPerpage', {
            perpage: this.value
        });
    })

    const getProvince = async () => {
        try {
            const response = await fetch('https://provinces.open-api.vn/api/')
            const result = await response.json();
            return result;
        } catch (error) {
            console.log(">>>", error);
        }
    }

    const rendeProvince = async () => {
        const provinces = await getProvince()
        let html = '<option class="option"  value="">Chọn Tỉnh/thành phố</option>'
        const dom = document.querySelector('.address')
        provinces.forEach(element => {
            html +=
                `<option class="option"  value="${element.codename}">${element.name}</option>`;
        });
        const list = dom.querySelector('.nice-select').querySelector('.list')
        list.innerHTML = html
        const options = list.querySelectorAll('.option')
        options.forEach((element) => {
            element.onclick = () => {
                let value = element.value
                value = value.split('_')
                value = value.splice(-2).join(' ')

                Livewire.dispatch('updatedProvince', {
                    province: value
                });

            }
        })

    }
    rendeProvince()
})