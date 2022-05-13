<html lang="es"><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto, Mercedes Fried Chicken</title>
    <meta name="description" content="Quieres agendar hora para un evento? contactate con nosotros">
    <meta name="keywords" content="Mercedes, Soriano , Uruguay, Pollo frito, Burgers, Comida rapida, Delivery, Papas fritas, Ensalada, Cerveza Artesanal, Bebida">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    @livewireStyles
    <style>@charset "UTF-8";
        @import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Amatic+SC&display=swap");
        * {
          margin: 0;
          padding: 0;
          -webkit-box-sizing: border-box;
                  box-sizing: border-box;
        }

        body {
          overflow-x: hidden;
        }

        .index img {
          width: 100%;
          height: 80vh;
          -o-object-fit: cover;
             object-fit: cover;
        }

        .index .responsive {
          width: 100%;
          height: auto;
        }

        header {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-align: center;
              -ms-flex-align: center;
                  align-items: center;
          -webkit-box-pack: justify;
              -ms-flex-pack: justify;
                  justify-content: space-between;
          background-image: url("img/Diseño sin título.jpg");
          height: 120px;
          width: 100%;
        }

        header .container-logo {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-align: center;
              -ms-flex-align: center;
                  align-items: center;
        }

        header nav {
          float: right;
          margin-right: 10px;
          margin-top: 15px;
          padding: 10px 0;
        }

        header .titulo_pages {
          float: right;
          font-size: 28px;
          -webkit-box-align: center;
              -ms-flex-align: center;
                  align-items: center;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
        }

        header ul {
          display: fixed;
          list-style: none;
        }

        header ul li {
          display: inline-block;
          margin-left: 10px;
          margin-right: 10px;
        }

        header ul li:hover {
          -webkit-transform: scale(1.2);
                  transform: scale(1.2);
          -webkit-transition: 0.3s;
          transition: 0.3s;
        }

        header ul li:hover a:hover {
          text-decoration: none;
        }

        header ul li a {
          color: white;
          text-decoration: none;
          font-size: 20px;
          text-transform: capitalize;
          font-family: 'Bebas Neue', cursive;
          padding: 10px 0;
        }

        header ul li a:hover {
          color: #000;
        }

        \* #hamburger-icon {
          float: right;
          -webkit-box-align: center;
              -ms-flex-align: center;
                  align-items: center;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          margin: 15px;
          cursor: pointer;
        }

        \* #hamburger-icon div {
          width: 35px;
          height: 3px;
          background-color: white;
          margin: 6px 0;
          -webkit-transition: 0.4s;
          transition: 0.4s;
        }

        .navt {
          font-size: 11px;
          font-family: Verdana, Geneva, Tahoma, sans-serif;
          color: white;
          text-align: center;
          text-transform: capitalize;
        }

        .open .bar1 {
          -webkit-transform: rotate(-45deg) translate(-6px, 6px);
          transform: rotate(-45deg) translate(-6px, 6px);
        }

        .open .bar2 {
          opacity: 0;
        }

        .open .bar3 {
          -webkit-transform: rotate(45deg) translate(-6px, -8px);
          transform: rotate(45deg) translate(-6px, -8px);
        }

        .open .mobile-menu {
          z-index: 4;
          margin-top: -10px;
          background-color: #000;
          height: 100vh;
          width: 100%;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: vertical;
          -webkit-box-direction: normal;
              -ms-flex-direction: column;
                  flex-direction: column;
          -webkit-box-align: center;
              -ms-flex-align: center;
                  align-items: center;
          -webkit-box-pack: start;
              -ms-flex-pack: start;
                  justify-content: flex-start;
        }

        .open .mobile-menu li {
          height: 55px;
          width: 100%;
          margin: 20px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-align: center;
              -ms-flex-align: center;
                  align-items: center;
          -webkit-box-pack: center;
              -ms-flex-pack: center;
                  justify-content: center;
        }

        .open .mobile-menu li:hover {
          background-color: white;
        }

        .open .mobile-menu li:hover a {
          color: #000;
        }

        .mobile-menu {
          display: none;
          position: absolute;
          top: 130px;
          left: 0px;
          height: calc(100vh - 50px);
          width: 100%;
        }

        main {
          width: 100%;
          text-align: center;
          background-size: cover;
          background-position: center;
          -o-object-fit: cover;
             object-fit: cover;
        }

        main.index {
          background-image: url(img/chicken-nuggets-with-french-fries-and-human-hand-in-clay-dishes.jpg);
          background-size: cover;
          background-position: center;
          -o-object-fit: center;
             object-fit: center;
          padding: 0px 25px 0px 25px;
        }

        section {
          width: 100%;
          color: #000;
          text-align: center;
        }

        .table {
          font-family: Verdana, Geneva, Tahoma, sans-serif;
          margin: 15px auto 15px auto;
          width: 80%;
          height: 100px;
        }

        .tikets {
          width: 80%;
          margin: 10px auto 10px auto;
          text-align: center;
        }

        .container_img_promociones {
          width: 100%;
          height: 600px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: normal;
              -ms-flex-direction: row;
                  flex-direction: row;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
        }

        .container_img_promociones .card {
          width: 450px;
          height: 575px;
          -webkit-box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
          -webkit-box-align: center;
              -ms-flex-align: center;
                  align-items: center;
          -ms-flex-line-pack: center;
              align-content: center;
        }

        .container_img_promociones .card h5 {
          margin-top: 5px;
        }

        section .noticias {
          font-size: 150px;
        }

        .label {
          display: inline-block;
          min-width: 60px;
          text-align: left;
        }

        .noticias p {
          font-size: 12px;
          font-family: Verdana, Geneva, Tahoma, sans-serif;
          font-weight: lighter;
          margin: 0px 20px 20px 20px;
          color: #000;
          text-align: center;
          text-transform: lowercase;
        }

        .noticias p span {
          color: #B8AF49;
        }

        fieldset {
          width: 20%;
          padding-top: 15px;
          padding-bottom: 15px;
        }

        form {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-pack: center;
              -ms-flex-pack: center;
                  justify-content: center;
        }

        footer {
          height: auto;
          width: 100%;
          background-image: url("img/Diseño sin título.jpg");
          color: #000;
          font-size: 30px;
          text-align: center;
          padding-top: 30px;
        }

        footer p {
          font-size: 22px;
          padding: 10px;
          margin-top: 5px;
          margin-bottom: 0;
        }

        footer p span {
          color: white;
        }

        footer .src {
          color: white;
        }

        .Container1 {
          margin: 15px;
          width: 100%;
          height: 500px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: normal;
              -ms-flex-direction: row;
                  flex-direction: row;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
        }

        .Container1 img {
          border-radius: 15px;
          width: 450px;
          height: 450px;
          margin: 10px 10px 10px 10px;
        }

        .Container1 p {
          margin: 10px 40px 10px 10px;
        }

        .Container2 {
          margin: 15px;
          width: 100%;
          height: 500px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: reverse;
              -ms-flex-direction: row-reverse;
                  flex-direction: row-reverse;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
        }

        .Container2 img {
          border-radius: 15px;
          width: 450px;
          height: 450px;
          margin: 10px 40px 10px 10px;
        }

        .Container2 p {
          margin: 10px 10px 10px 10px;
        }

        .ContainerBurgers {
          width: 100%;
          height: auto;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
          gap: 30px;
          margin: auto;
        }

        .ContainerFriedChicken {
          width: 100%;
          height: auto;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
          gap: 30px;
          margin: auto;
        }

        .ContainerEspeciales {
          width: 100%;
          height: auto;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
          gap: 30px;
          margin: auto;
          padding-bottom: 50px;
        }

        .ContainerMenu .card {
          -webkit-box-shadow: -1px 0px 5px 3px rgba(117, 117, 117, 0.1);
                  box-shadow: -1px 0px 5px 3px rgba(117, 117, 117, 0.1);
        }

        .ContainerMenu .card .card-body {
          min-height: 200px;
        }

        .Containercheff {
          width: 100%;
          height: 300px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: normal;
              -ms-flex-direction: row;
                  flex-direction: row;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
        }

        .Containercheff img {
          border-radius: 30px;
          width: 450px;
          height: 300px;
          margin-left: 25px;
        }

        .Containercheff p {
          margin: 10px 10px 10px 10px;
        }

        .Containerlocal {
          width: 100%;
          height: 500px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: reverse;
              -ms-flex-direction: row-reverse;
                  flex-direction: row-reverse;
          -webkit-box-pack: space-evenly;
              -ms-flex-pack: space-evenly;
                  justify-content: space-evenly;
        }

        .Containerlocal img {
          border-radius: 30px;
          width: 450px;
          height: 450px;
          margin-right: 25px;
        }

        .Containerlocal p {
          margin: 10px 10px 10px 10px;
        }

        .containercontacto {
          width: 100%;
          height: 900px;
          margin-top: 30px;
        }

        .containercontacto form {
          width: 700px;
          height: 450px;
          display: inline;
        }

        .containercontacto form input {
          width: 50%;
          border-radius: 5px;
          border: 1px solid black;
          filter: drop-shadow(5px 5px 1px #b1a327);
          background-color: #f5f76d56;
          color: #0c1225;
          padding: 12px 20px;
          -webkit-box-sizing: border-box;
                  box-sizing: border-box;
        }

        .containercontacto p {
          font-family: Verdana, Geneva, Tahoma, sans-serif;
          font-size: 15px;
        }

        .containercontacto label {
          width: 50%;
          margin-top: 10px;
          margin-bottom: 1px;
          font-family: "Amatic SC", cursive;
          font-size: 25px;
          color: black;
          display: inline-block;
        }

        .containercontacto .btn {
          width: 200px;
          height: 35px;
          border-radius: 5px;
          border: 1px solid black;
          filter: drop-shadow(5px 5px 1px #b1a327);
          background-color: #f5f76d56;
          font-size: 25px;
          font-family: "Amatic SC", cursive;
          margin-top: 20px;
          background-image: -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(97%, transparent), color-stop(90%, black), to(black));
          background-image: linear-gradient(transparent 0%, transparent 97%, black 90%, black 100%);
          background-repeat: no-repeat;
          background-size: 0% 100%;
          background-position-x: right;
          -webkit-transition: background-size 300ms;
          transition: background-size 300ms;
        }

        .containercontacto .btn:hover {
          background-size: 100% 100%;
          background-position-x: left;
        }

        .containercontacto li {
          list-style: none;
        }

        textarea {
          width: 50%;
          height: 150px;
          background-color: #ecf6f2;
          color: #0c1225;
          padding: 12px 20px;
          -webkit-box-sizing: border-box;
                  box-sizing: border-box;
          border: 1px solid black;
          border-radius: 4px;
          resize: none;
        }

        h1 {
          font-size: 40px;
          font-family: "Amatic SC", cursive;
          margin-top: 15px;
          color: #000;
          text-align: center;
          font-weight: 600;
        }

        h2 {
          font-size: 35px;
          font-family: "Amatic SC", cursive;
          margin-top: 20px;
          margin-bottom: 20px;
          color: #000;
          text-align: center;
          text-transform: capitalize;
        }

        h3 {
          font-size: 30px;
          font-family: "Amatic SC", cursive;
          color: #000;
          text-align: center;
          text-transform: capitalize;
          font-weight: lighter;
        }

        h4 {
          font-size: 30px;
          font-family: "Amatic SC", cursive;
          color: #000;
          text-align: center;
          text-transform: capitalize;
        }

        hr {
          margin-left: 50px;
          margin-right: 50px;
        }

        @media only screen and (min-width: 319px) and (max-width: 560px) {
          .container_img_promociones {
            width: 100%;
            height: 1250px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
            -webkit-box-pack: justify;
                -ms-flex-pack: justify;
                    justify-content: space-between;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
          }
          .container_img_promociones .card {
            width: 250px;
            height: auto;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            -ms-flex-line-pack: center;
                align-content: center;
          }
          .container-logo img {
            width: 100px;
            height: 100px;
          }
          header nav ul {
            display: none;
          }
          header .container-logo p {
            display: none;
          }
          .PN {
            margin-top: 15px;
            font-size: 25px;
            font-family: 'Bebas Neue', cursive;
            text-align: center;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
          }
          .PNC {
            font-size: 12px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            text-align: center;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
          }
          #hamburger-icon div {
            width: 20px;
            height: 2px;
            background-color: white;
            margin: 6px 0;
            -webkit-transition: 0.4s;
            transition: 0.4s;
          }
          .container_img_promociones {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
          }
          .producto {
            height: 100%;
            width: 100%;
          }
          .producto img {
            width: 100%;
          }
          .table {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 15px auto 15px auto;
            width: 60%;
            height: 100px;
          }
          .Container1 {
            margin: auto;
            width: 100%;
            height: auto;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
            -webkit-box-pack: space-evenly;
                -ms-flex-pack: space-evenly;
                    justify-content: space-evenly;
          }
          .Container1 img {
            border-radius: 15px;
            width: 350px;
            height: 350px;
            margin: auto;
            margin-top: 15px;
          }
          .Container1 p {
            margin: 10px 10px 10px 10px;
          }
          .Container2 {
            margin: auto;
            width: 100%;
            height: auto;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
            -webkit-box-pack: space-evenly;
                -ms-flex-pack: space-evenly;
                    justify-content: space-evenly;
          }
          .Container2 img {
            border-radius: 15px;
            width: 350px;
            height: 350px;
            margin: auto;
            margin-top: 15px;
          }
          .Container2 p {
            margin: 10px 10px 10px 10px;
          }
          .Containercheff {
            width: 100%;
            height: auto;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
            -webkit-box-pack: justify;
                -ms-flex-pack: justify;
                    justify-content: space-between;
          }
          .Containercheff img {
            margin: auto;
            width: 350px;
            height: 250px;
          }
          .Containercheff p {
            margin: 10px 10px 10px 10px;
          }
          .Containerlocal {
            width: 100%;
            height: auto;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
            -webkit-box-pack: justify;
                -ms-flex-pack: justify;
                    justify-content: space-between;
          }
          .Containerlocal img {
            margin: auto;
            width: 350px;
            height: 350px;
          }
          .Containerlocal p {
            margin: 10px 10px 10px 10px;
          }
          .containercontacto {
            width: 100%;
            height: 850px;
            margin-top: 30px;
          }
          .containercontacto form {
            width: 700px;
            height: 450px;
            display: inline;
          }
          .containercontacto form input {
            width: 75%;
            border: 1px solid black;
            background-color: #ecf6f2;
            color: #073df1;
            padding: 12px 20px;
            -webkit-box-sizing: border-box;
                    box-sizing: border-box;
          }
          .containercontacto p {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 15px;
            margin-top: 10px;
            margin-left: 15px;
            margin-right: 15px;
          }
          .containercontacto label {
            width: 50%;
            margin-top: 10px;
            margin-bottom: 1px;
            font-family: 'Amatic SC', cursive;
            font-size: 25px;
            color: black;
            display: inline-block;
          }
          .containercontacto .btn {
            width: 200px;
            height: 35px;
            font-size: 25px;
            font-family: 'Amatic SC', cursive;
            margin-top: 20px;
            border: 1px solid black;
            background-color: #ecf6f2;
          }
          textarea {
            width: 75%;
            height: 150px;
            background-color: #ecf6f2;
            color: #0c1225;
            padding: 12px 20px;
            -webkit-box-sizing: border-box;
                    box-sizing: border-box;
            border: 1px solid black;
            border-radius: 4px;
            resize: none;
          }
          footer {
            height: auto;
            width: 100%;
            background-image: url("img/Diseño sin título.jpg");
            text-align: center;
          }
          footer i {
            height: 35px;
            width: 35px;
          }
          footer p {
            font-size: 20px;
            padding: 10px;
            margin-top: 10px;
          }
          footer p span {
            color: white;
          }
        }

        @media only screen and (min-width: 559px) and (max-width: 1023px) {
          header nav ul {
            display: none;
          }
          .container_img_promociones {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
          }
        }

        @media only screen and (min-width: 1023px) and (max-width: 1459px) {
          #hamburger-icon {
            display: none;
          }
          .p1 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1/2;
            -ms-grid-row: 1;
            -ms-grid-row-span: 1;
            grid-row: 1/2;
          }
          .p2 {
            -ms-grid-column: 2;
            -ms-grid-column-span: 1;
            grid-column: 2/3;
            -ms-grid-row: 1;
            -ms-grid-row-span: 1;
            grid-row: 1/2;
          }
          .p3 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1/2;
            -ms-grid-row: 2;
            -ms-grid-row-span: 1;
            grid-row: 2/3;
          }
          .p4 {
            -ms-grid-column: 2;
            -ms-grid-column-span: 1;
            grid-column: 2/3;
            -ms-grid-row: 2;
            -ms-grid-row-span: 1;
            grid-row: 2/3;
          }
          .p5 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1/2;
            -ms-grid-row: 3;
            -ms-grid-row-span: 1;
            grid-row: 3/4;
          }
          .p6 {
            -ms-grid-column: 2;
            -ms-grid-column-span: 1;
            grid-column: 2/3;
            -ms-grid-row: 3;
            -ms-grid-row-span: 1;
            grid-row: 3/4;
          }
          .p7 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1/2;
            -ms-grid-row: 4;
            -ms-grid-row-span: 1;
            grid-row: 4/5;
          }
          .p8 {
            -ms-grid-column: 2;
            -ms-grid-column-span: 1;
            grid-column: 2/3;
            -ms-grid-row: 4;
            -ms-grid-row-span: 1;
            grid-row: 4/5;
          }
          .p9 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 2;
            grid-column: 1/3;
            -ms-grid-row: 5;
            -ms-grid-row-span: 2;
            grid-row: 5/7;
          }
        }

        @media only screen and (min-width: 1460px) {
          #hamburger-icon {
            display: none;
          }
          .p1 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1/2;
            -ms-grid-row: 1;
            -ms-grid-row-span: 1;
            grid-row: 1/2;
          }
          .p2 {
            -ms-grid-column: 2;
            -ms-grid-column-span: 1;
            grid-column: 2/3;
            -ms-grid-row: 1;
            -ms-grid-row-span: 1;
            grid-row: 1/2;
          }
          .p3 {
            -ms-grid-column: 3;
            -ms-grid-column-span: 1;
            grid-column: 3/4;
            -ms-grid-row: 1;
            -ms-grid-row-span: 1;
            grid-row: 1/2;
          }
          .p4 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1/2;
            -ms-grid-row: 2;
            -ms-grid-row-span: 1;
            grid-row: 2/3;
          }
          .p5 {
            -ms-grid-column: 2;
            -ms-grid-column-span: 1;
            grid-column: 2/3;
            -ms-grid-row: 2;
            -ms-grid-row-span: 1;
            grid-row: 2/3;
          }
          .p6 {
            -ms-grid-column: 3;
            -ms-grid-column-span: 1;
            grid-column: 3/4;
            -ms-grid-row: 2;
            -ms-grid-row-span: 1;
            grid-row: 2/3;
          }
          .p7 {
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1/2;
            -ms-grid-row: 3;
            -ms-grid-row-span: 1;
            grid-row: 3/4;
          }
          .p8 {
            -ms-grid-column: 2;
            -ms-grid-column-span: 1;
            grid-column: 2/3;
            -ms-grid-row: 3;
            -ms-grid-row-span: 1;
            grid-row: 3/4;
          }
          .p9 {
            -ms-grid-column: 3;
            -ms-grid-column-span: 1;
            grid-column: 3/4;
            -ms-grid-row: 3;
            -ms-grid-row-span: 1;
            grid-row: 3/4;
          }
        }
        /*# sourceMappingURL=estilos.css.map */</style>
</head>

<body>
    <!-- fila de logo + nav-->
    <header>
        <div class="container-logo">
            <img src="https://mathiasmoyano.github.io/idea-Moyano/img/logo.png" alt="Logo Mercedes Fried Chicken" width="120px">
        </div>
    </header>
    <main>
        <div class="titulos_pages">
            <h1>¿Será tu dia de suerte?</h1>
        </div>
        @yield('content')
    </main>
    <footer>
        <i class="fa-brands fa-facebook-square"></i>
        <i class="fa-brands fa-whatsapp-square"></i>
        <i class="fa-brands fa-instagram-square"></i>
        <p>Mercedes Fried Chicken<br> <span>Mercedes Uruguay Since 2020</span></p>
    </footer>
    @livewireScripts
</body></html>
