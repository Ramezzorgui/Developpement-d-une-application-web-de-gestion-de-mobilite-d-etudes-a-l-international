pipeline {
  agnet any 
  tools{
    maven 'M2_HOME'
  }
  stages {
    stage ('GIT'){
      steps {
          git branch: 'master',
          url: 'https://github.com/Ramezzorgui/Developpement-d-une-application-web-de-gestion-de-mobilite-d-etudes-a-l-international.git',
          credentialsId: 'jenkins-example-github-pat'
      }
    }
  }
}
