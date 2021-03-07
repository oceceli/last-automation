<div>
    <aside><img src="http://www.cmbcontracting.com/images/404.png" alt="404 Image" />
    </aside>
    <main>
      <h1>Bulunamadı!</h1>
      <p>
      </p>
      <a href="{{ url('/') }}">Anasayfaya dön!</a>
    </main>
  </div>


  <style>
      @import url("https://fonts.googleapis.com/css2?family=Fontdiner+Swanky&family=Roboto:wght@500&display=swap");
* {
  box-sizing: 0;
  margin: 0;
  padding: 0;
  cursor: url("https://cdn.bytesin.com/software/media/icons/206331.gif"), auto;
}
body {
  background: linear-gradient(to right, white 50%, #383838 50%);
  font-family: "Roboto", sans-serif;
  font-size: 18px;
  font-weight: 500;
  line-height: 1.5;
  color: white;
}
div {
  display: flex;
  align-items: center;
  height: 100vh;
  max-width: 1000px;
  width: calc(100% - 4rem);
  margin: 0 auto;
}
div > * {
  display: flex;
  flex-flow: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  max-width: 500px;
  width: 100%;
  padding: 2.5rem;
}
aside {
  background-image: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/4424790/right-edges.png");
  background-position: top right;
  background-repeat: no-repeat;
  background-size: 25px 100%;
}
aside img {
  display: block;
  height: auto;
  width: 100%;
}
main {
  text-align: center;
}
main h1 {
  font-family: "Fontdiner Swanky", cursive;
  font-size: 4rem;
  color: #c5dc50;
  margin-bottom: 1rem;
}
main p {
  margin-bottom: 2.5rem;
}
main p em {
  font-style: italic;
  color: #c5dc50;
}
main a {
  font-family: "Fontdiner Swanky", cursive;
  font-size: 1rem;
  color: #383838;
  border: none;
  background-color: #f36a6f;
  padding: 1rem 2.5rem;
  transform: skew(-5deg);
  transition: all 0.1s ease;
  cursor: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/4424790/cursors-eye.png"), auto;
}
main a:hover {
  background-color: #c5dc50;
  transform: scale(1.15);
}
@media (max-width: 700px) {
  body {
    background: #383838;
    font-size: 16px;
  }
  div {
    flex-flow: column;
  }
  div > * {
    max-width: 700px;
    height: 100%;
  }
  aside {
    background-image: none;
    background-color: white;
  }
  aside img {
    max-width: 300px;
  }
}

  </style>