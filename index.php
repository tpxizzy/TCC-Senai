<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Miau e AuAu Petshop</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
      color: #333;
      line-height: 1.6;
    }

    header {
      background: linear-gradient(90deg, #007bff, #0056b3);
      color: white;
      text-align: center;
      padding: 20px;
      position: relative;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    header .logo img {
      max-width: 120px;
      border-radius: 50%;
      margin-bottom: 10px;
      padding-top: 25px;
    }

    header h1 {
      font-size: 2.5rem;
    }

    header p {
      font-size: 1.2rem;
      font-weight: 300;
      padding-bottom: 80px;
    }

    .menu-hamburguer {
      position: absolute;
      top: 20px;
      left: 20px;
      width: 30px;
      height: 25px;
      cursor: pointer;
      z-index: 10;
      display: flex;
      flex-direction: column;
      justify-content: space-around;
    }

    .menu-hamburguer div {
      height: 4px;
      width: 100%;
      background-color: white;
      border-radius: 2px;
      transition: all 0.3s ease-in-out;
    }

    .menu-hamburguer.active div:nth-child(1) {
      transform: translateY(9px) rotate(45deg);
    }

    .menu-hamburguer.active div:nth-child(2) {
      opacity: 0;
    }

    .menu-hamburguer.active div:nth-child(3) {
      transform: translateY(-9px) rotate(-45deg);
    }

    .menu {
      max-height: 0;
      overflow: hidden;
      flex-direction: column;
      align-items: center;
      background: #007bff;
      padding: 0 15px;
      position: absolute;
      top: 60px;
      left: 20px;
      width: 200px;
      border-radius: 0 0 8px 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 9;
      transition: max-height 0.4s ease, padding 0.4s ease;
    }

    .menu.active {
      max-height: 600px;
      padding: 15px;
    }

    .menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
      width: 100%;
    }

    .menu ul li {
      margin: 10px 0;
    }

    .menu ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s;
      display: block;
      padding: 8px 12px;
      border-radius: 6px;
    }

    .menu ul li a:hover {
      color: #ffdd57;
      background-color: blue;
    }

    main {
      padding: 40px 20px;
      max-width: 900px;
      margin: 0 auto;
    }

    section {
      margin-bottom: 60px;
    }

    section h2 {
      color: #007bff;
      margin-bottom: 15px;
      font-size: 2rem;
      border-bottom: 2px solid #007bff;
      padding-bottom: 8px;
    }

    section p {
      color: #333;
      margin-bottom: 20px;
      font-size: 1.1rem;
    }

    .precos ul {
      list-style: none;
      padding-left: 0;
      font-size: 1.1rem;
    }

    .precos li {
      background-color: #e9f2ff;
      margin-bottom: 15px;
      padding: 15px 20px;
      border-radius: 8px;
      border-left: 6px solid #007bff;
      font-weight: 600;
    }

    iframe {
      width: 100%;
      max-width: 100%;
      height: 400px;
      border-radius: 8px;
      border: 2px solid #ccc;
    }

    .btn-agendar {
      display: inline-block;
      background-color: #007bff;
      color: white;
      padding: 14px 28px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s;
      margin-top: 20px;
      font-size: 1.1rem;
    }

    .btn-agendar:hover {
      background-color: #0056b3;
    }

    footer {
      background: #f8f9fa;
      color: #555;
      text-align: center;
      padding: 20px;
      border-top: 3px solid #007bff;
      font-size: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="assets/logopet.png" alt="Logo Miau e AuAu Petshop" />
    </div>
    <h1>Bem-vindo ao Miau e AuAu Petshop</h1>
    <p>Miou, latiu, sorriu!</p>

   <!-- Botão Menu Hambúrguer -->
   <div class="menu-hamburguer" aria-label="Menu" role="button" tabindex="0">
      <div></div>
      <div></div>
      <div></div>
    </div>

    <!-- Navegação -->
    <nav class="menu" aria-label="Menu de navegação">
      <ul>
        <li><a href="#about">Sobre Nós</a></li>
        <li><a href="#services">Serviços</a></li>
        <li><a href="#agendamento-info">Agendamento</a></li>
        <li><a href="#location">Localização</a></li>
        <li><a href="#contact">Contato</a></li>
        <li><a href="agendamento.php">Agendar Agora</a></li>
        <li><a href="login.php">Sou Funcionário</a></li>
        <li><a href="meus_agendamentos.php">Meus Agendamentos</a></li> <!-- Agora está no menu -->
      </ul>
    </nav>
  </header>

  <main>
    <section id="about">
      <h2>Sobre Nós</h2>
      <p>O Miau e AuAu Petshop é uma referência local em cuidado animal, com mais de 10 anos de experiência dedicados à saúde e felicidade dos pets. Nossa equipe apaixonada e qualificada está sempre pronta para oferecer um atendimento personalizado para cada cliente.</p>
      <p>Nosso espaço é climatizado e seguro, com equipamentos modernos e ambientes limpos, garantindo o conforto do seu amigo de quatro patas.</p>
      <p>Nosso compromisso vai além dos serviços: queremos construir uma relação de confiança e carinho entre você, seu pet e nossa equipe.</p>
    </section>

    <section id="services">
      <h2>Nossos Serviços</h2>
      <p>Oferecemos uma variedade completa de serviços para atender todas as necessidades do seu pet, sempre com muito amor e profissionalismo.</p>
      <div class="precos">
        <ul>
          <li><strong>Consulta Veterinária:</strong> R$ 100,00 – Avaliação completa para manter seu pet saudável.</li>
          <li><strong>Banho e Tosa:</strong> R$ 50,00 – Higiene e beleza para seu pet, com produtos de qualidade.</li>
          <li><strong>Tosa Especializada:</strong> R$ 25,00 – Corte personalizado de acordo com a raça e estilo do seu pet.</li>
          <li><strong>Vacinação:</strong> R$ 65,00 – Vacine seu pet para preservar sua saúde.</li>
        </ul>
      </div>
      
      <p>Além disso, oferecemos dicas de cuidados e produtos selecionados para o bem-estar do seu animal em nossa loja presencial.</p>
    </section>

    <section id="agendamento-info">
      <h2>Como Funciona o Agendamento</h2>
      <p>Nosso sistema de agendamento foi desenvolvido para facilitar sua vida e garantir que seu pet receba o melhor atendimento no horário mais conveniente para você.</p>
      <p>Veja como é simples:</p>
      <ul>
        <li>✅ Escolha o serviço desejado.</li>
        <li>✅ Preencha as informações do seu pet.</li>
        <li>✅ Selecione a data e horário disponíveis.</li>
        <li>✅ Receba a confirmação por e-mail ou telefone.</li>
      </ul>
      <a href="agendamento.php" class="btn-agendar">Agendar um Horário</a>
    </section>

    <section id="location">
      <h2>Localização</h2>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.83543450912!2d-122.42176108468132!3d37.774929779759095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808581d5!2sLocal%20do%20Petshop!5e0!3m2!1spt-BR!2sbr!4v1234567890"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </section>

    <section id="contact">
      <h2>Contato</h2>
      <p><strong>Telefone:</strong> (31) 9 1111-1111</p>
      <p><strong>Email:</strong> contato@miauauaupetshop.com</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Miau e AuAu Petshop. Todos os direitos reservados.</p>
  </footer>

  <script>
    const menuHamburguer = document.querySelector('.menu-hamburguer');
    const menu = document.querySelector('.menu');
    const menuLinks = document.querySelectorAll('.menu a');

    menuHamburguer.addEventListener('click', () => {
      menuHamburguer.classList.toggle('active');
      menu.classList.toggle('active');
    });

    document.addEventListener('click', (event) => {
      if (!menu.contains(event.target) && !menuHamburguer.contains(event.target)) {
        menuHamburguer.classList.remove('active');
        menu.classList.remove('active');
      }
    });

    menuHamburguer.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        menuHamburguer.classList.toggle('active');
        menu.classList.toggle('active');
      }
    });

    menuLinks.forEach(link => {
      link.addEventListener('click', () => {
        menuHamburguer.classList.remove('active');
        menu.classList.remove('active');
      });
    });
  </script>
</body>
</html>
