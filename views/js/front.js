$(document).ready(function(){
  $('#owl-carousel-1').owlCarousel(
    {
      items: 5, // Количество показанных новостей
      
      loop: true, // Показывать слайды покругу

      margin: 10,  // Отступ

      autoplay: true,  // Автоматическое проигрывание
      autoplayTimeout: 1500
    }
  );
  
});