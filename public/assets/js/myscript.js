/**
 * File         : myscript.js
 * Description  : JS app
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 2 Mar 2023
 * Last Update  : 31 Mar 2023
**/

// public variable & function
var _table;
var _datatable;
var _mod;
var _sts;
var _csrf_content = $('meta[name="X-CSRF-TOKEN"]').attr('content');

// select choices
// class choices di sini untuk choices bukan modal
// untuk modal, class modal-choices dan script ini langsung disimpan di modalnya
let choices = document.querySelectorAll('.choices');
let initChoice;
for(let i = 0; i < choices.length; i++) {
    if (choices[i].classList.contains("multiple-remove")) {
        initChoice = new Choices(choices[i],
        {
            delimiter: ',',
            editItems: true,
            maxItemCount: -1,
            removeItemButton: true,
        });
    } else {
        initChoice = new Choices(choices[i]);
    }
}
// untuk menu level 3
let sml = document.querySelectorAll(".submenu-link");
let ssm = document.querySelectorAll(".subsubmenu");
sml.forEach(function(sml_current, index) {
    sml_current.addEventListener("click", function(e) {
        e.preventDefault();
        let o = ssm[index];

        if (o.classList.contains("active")) {
            o.classList.remove("active");
            o.style.display = "none";
        } else {
            o.classList.add("active");
            o.style.display = "block";
        }
    });
});
// fungsi untuk update csrf token
function updateCSRF(_token) {
    // variable global
    _csrf_content = _token;
    // untuk meta di head (ajax)
    $('meta[name="X-CSRF-TOKEN"]').attr('content', _token);
    // untuk form inputan jika ada
    if (typeof $('input[name="csrf_token_name"]') !== "undefined") {
        $('input[name="csrf_token_name"]').attr('value', _token);
    }
}
// fungsi untuk show modal
function openModal(_url, _size, _title, e) {
    e.preventDefault();
    // ukuran modal, .modal-{sm|lg|xl|full}
    $('#my-modal').find('.modal-dialog').addClass(_size);
    $('#my-modal').find('.modal-body').html('');
    $.get(_url, function(result) {
        $('#my-modal').find('.modal-title').html(_title);
        $('#my-modal').find('.modal-body').html(result);
        /* belum jalan
        $('#my-modal').modal({
            cache: false,
            backdrop: 'static',
            keyboard: false
        },'show');
        */
        $('#btn-modal-trigger').trigger('click');
    });
}
// fungsi konfirmasi saat hapus data
function deleteData(_url, _id, _msg, e) {
    e.preventDefault();
    swal.fire({
        title: 'Anda yakin?',
        text: _msg,
        icon: 'question',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-danger me-1',
        cancelButtonClass: 'btn btn-default',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        buttonsStyling: false
    }).then(function(result) {
        if (result.value) {
            // csrf_token_name harus disertakan jika csrf diaktifkan di Config/Filters.php
            $.post(_url, {id:_id, csrf_token_name: _csrf_content}, function(result) {
                let _res = JSON.parse(result);
                // jika csrf diaktifkan di Config/Filters.php
                updateCSRF(_res.csrf_content);
                // jika ingin pake datatable reload,
                // csrf token harus disertakan pada respon ajax
                // menggunakan location.reload(); ga perlu sertakan csrf token pada respon ajax
                if (_res.rc == '1') {
                    swalMsg('Sukses', _res.rd, 'success', function() {
                        _datatable.ajax.reload();
                    });
                } else {
                    swalMsg('Gagal', _res.rd, 'error', function() {
                        _datatable.ajax.reload();
                    });
                }
            });
        }
    });
}
// fungsi untuk Sweet Alert Msg
function swalMsg(_title, _text, _icon, callback) {
    swal.fire({
        title: _title,
        text: _text,
        icon: _icon,
        confirmButtonClass: "btn btn-sm btn-primary",
        buttonsStyling: false
    }).then(function() {
        callback();
    }).catch(swal.noop);
}
// fungsi untuk Toastify Msg
function ToastifyMsg(_title, _text, _type, _icon, _position) {
    document.querySelector('.toast-title').innerHTML = _title;
    document.querySelector('.toast-body').innerHTML = _text;
    // menggunakan bootstrap toasts
    const _TOAST = document.querySelector('.toast');
    let _positions = _position.split(' ');
    _TOAST.classList.add(_type);
    DOMTokenList.prototype.add.apply(_TOAST.classList, _positions);
    const _msg = new bootstrap.Toast(_TOAST);
    _msg.show();
}
// fungsi untuk konversi 999.999,00 ke 999999.00
function stringToNumber(_val, _dec) {
    if (_val == null || _val == '') {
        _val = '0';
    }

    var _number_string = _val;
    _number_string = _number_string
        .replace(/\./g, '')  // replace all separators
        .replace(/,/, '.');  // replace comma with dot

    var _parsed = parseFloat(_number_string).toFixed(_dec);

    return _parsed;
}
// fungsi untuk format angka jadi 999,999.00 atau 999.999,00
var numberFormat = function (number, decimals, dec_point, thousands_sep) {
    // discuss at: http://phpjs.org/functions/number_format/
    // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: davook
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Theriault
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Michael White (http://getsprink.com)
    // bugfixed by: Benjamin Lupton
    // bugfixed by: Allan Jensen (http://www.winternet.no)
    // bugfixed by: Howard Yeend
    // bugfixed by: Diogo Resende
    // bugfixed by: Rival
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    // revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // revised by: Luke Smith (http://lucassmith.name)
    // input by: Kheang Hok Chin (http://www.distantia.ca/)
    // input by: Jay Klehr
    // input by: Amir Habibi (http://www.residence-mixte.com/)
    // input by: Amirouche
    // example 1: number_format(1234.56);
    // returns 1: '1,235'
    // example 2: number_format(1234.56, 2, ',', ' ');
    // returns 2: '1 234,56'
    // example 3: number_format(1234.5678, 2, '.', '');
    // returns 3: '1234.57'
    // example 4: number_format(67, 2, ',', '.');
    // returns 4: '67,00'
    // example 5: number_format(1000);
    // returns 5: '1,000'
    // example 6: number_format(67.311, 2);
    // returns 6: '67.31'
    // example 7: number_format(1000.55, 1);
    // returns 7: '1,000.6'
    // example 8: number_format(67000, 5, ',', '.');
    // returns 8: '67.000,00000'
    // example 9: number_format(0.9, 0);
    // returns 9: '1'
    // example 10: number_format('1.20', 2);
    // returns 10: '1.20'
    // example 11: number_format('1.20', 4);
    // returns 11: '1.2000'
    // example 12: number_format('1.2000', 3);
    // returns 12: '1.200'
    // example 13: number_format('1 000,50', 2, '.', ' ');
    // returns 13: '100 050.00'
    // example 14: number_format(1e-8, 8, '.', '');
    // returns 14: '0.00000001'

    number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };

    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');

    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }

    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
        .join('0');
    }

    return s.join(dec);
}
// fungsi format tanggal dd-mm-yyyy
function dateFormat(_format, _date) {
    let _ret = '';
    let _arrstr;
    switch (_format) {
        case 'dd-mm-yyyy':
            _arrstr = _date.split('-');
            _ret = _arrstr[2]+'-'+_arrstr[1]+'-'+_arrstr[0];
            break;
    }
    return _ret;
}
// fungsi untuk format tanggal <input type="date">
function displayDateFormat(_obj, _label, _value) {
    $(_obj).css("color", "rgba(0,0,0,0)")
        .siblings(`${_label}`)
        .css({
            "position": "absolute",
            "left": "25px",
            "top": "9px",
            "width": $(_obj).width(),
            "z-index": "99",
            "font-size": ".9375rem",
            "color": "#607080"
        })
        .text(_value.length == 0 ? "" : (`${getDateFormat(new Date(_value))}`));
}
// this pattern dd/mm/yyyy
function getDateFormat(_value) {
    let d = new Date(_value);
    // you can set pattern you need
    let dstring = `${("0" + d.getDate()).slice(-2)}/${("0" + (d.getMonth() + 1)).slice(-2)}/${d.getFullYear()}`;
    return dstring;
}
// mendapatkan nama bulan
function getMonthID(_bln) {
    var _nm = '';

    switch (_bln) {
        case '1':
            _nm = "Januari";
            break;
        case '2':
            _nm = "Februari";
            break;
        case '3':
            _nm = "Maret";
            break;
        case '4':
            _nm = "April";
            break;
        case '5':
            _nm = "Mei";
            break;
        case '6':
            _nm = "Juni";
            break;
        case '7':
            _nm = "Juli";
            break;
        case '8':
            _nm = "Agustus";
            break;
        case '9':
            _nm = "September";
            break;
        case '10':
            _nm = "Oktober";
            break;
        case '11':
            _nm = "November";
            break;
        case '12':
            _nm = "Desember";
            break;
    }

    return _nm;
}

$(function() {

});

// program to encode a string to Base64
// create Base64 Object
const Base64 = {
    // private property
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    // public method for encoding
    encode : function (input) {
        let output = "";
        let chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        let i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
            Base64._keyStr.charAt(enc1) + Base64._keyStr.charAt(enc2) +
            Base64._keyStr.charAt(enc3) + Base64._keyStr.charAt(enc4);

        }

        return output;
    },

    // public method for decoding
    decode : function (input) {
        let output = "";
        let chr1, chr2, chr3;
        let enc1, enc2, enc3, enc4;
        let i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = Base64._keyStr.indexOf(input.charAt(i++));
            enc2 = Base64._keyStr.indexOf(input.charAt(i++));
            enc3 = Base64._keyStr.indexOf(input.charAt(i++));
            enc4 = Base64._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    },

    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        let utftext = "";

        for (let n = 0; n < string.length; n++) {

            let c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        let string = "";
        let i = 0;
        let c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }
        return string;
    }
}
