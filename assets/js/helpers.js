"use strict";
class Dateformat {
  constructor( ){
    this.months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    this.shMonths = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    // this.
  }
  render( ){
    let str = '';
    return str;
  }
  eightDigits(d){
    // let str = '';

    const month = d.getMonth() < 10 ? '0' + d.getMonth() : d.getMonth();
    const day = d.getDate() < 10 ? '0' + d.getDate() : d.getDate();
    //
    // str += `${d.getFullYear()}`;
    // str += `${d.getMonth()}`;
    // str += `${d.getDate()}`;

    return `${d.getFullYear()}${month}${day}`;
  }

  dmy (fd){
    // yyyymmdd;
    // 01234567

    // return `${fd.slice(6,8)}/${fd.slice(4,6)}/${fd.slice(0,4)}`;
    return `${fd.slice(6,8)}/${this.shMonths[parseInt(fd.slice(4,6))]}/${fd.slice(0,4)}`;
  }
}
