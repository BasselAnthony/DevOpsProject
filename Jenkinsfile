pipeline {
    environment {
    docker = '/usr/local/bin/docker'
  }
    agent any

    stages {
        stage('Cloning Git') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], extensions: [], userRemoteConfigs: [[url: 'https://github.com/BasselAnthony/DevOpsProject.git']]])  
                sh "ls "
                sh "whoami"
                nodejs('npm') {
                    sh "npm install"
                    sh "npm install -g docker"
                }
                echo 'Project Cloned'
            }
        }
        stage('Docker Build') {
            steps {
                echo 'Building..'
                script{
                    docker.withTool('docker') {
                    sh "docker-compose up -d"
                }
                echo 'Running...'
                }
            }
        }
        stage('Test') {
            steps {
                echo 'Testing..'
            }
        }
        stage('Deploy') {
            steps {
                echo 'Deploying....'
            }
        }
    }
}

// pipeline {
//     agent { node { label 'swarm-ci' } }

//     environment {
//         TEST_PREFIX = "test-IMAGE"
//         TEST_IMAGE = "${env.TEST_PREFIX}:${env.BUILD_NUMBER}"
//         TEST_CONTAINER = "${env.TEST_PREFIX}-${env.BUILD_NUMBER}"
//         REGISTRY_ADDRESS = "my.registry.address.com"

//         SLACK_CHANNEL = "#deployment-notifications"
//         SLACK_TEAM_DOMAIN = "MY-SLACK-TEAM"
//         SLACK_TOKEN = credentials("slack_token")
//         DEPLOY_URL = "https://deployment.example.com/"

//         COMPOSE_FILE = "docker-compose.yml"
//         REGISTRY_AUTH = credentials("docker-registry")
//         STACK_PREFIX = "my-project-stack-name"
//     }

//     stages {
//         stage("Prepare") {
//             steps {
//                 bitbucketStatusNotify buildState: "INPROGRESS"
//             }
//         }

//         stage("Build and start test image") {
//             steps {
//                 sh "docker-composer build"
//                 sh "docker-compose up -d"
//                 waitUntilServicesReady
//             }
//         }

//         stage("Run tests") {
//             steps {
//                 sh "docker-compose exec -T php-fpm composer --no-ansi --no-interaction tests-ci"
//                 sh "docker-compose exec -T php-fpm composer --no-ansi --no-interaction behat-ci"
//             }

//             post {
//                 always {
//                     junit "build/junit/*.xml"
//                     step([
//                             $class              : "CloverPublisher",
//                             cloverReportDir     : "build/coverage",
//                             cloverReportFileName: "clover.xml"
//                     ])
//                 }
//             }
//         }

//         stage("Determine new version") {
//             when {
//                 branch "master"
//             }

//             steps {
//                 script {
//                     env.DEPLOY_VERSION = sh(returnStdout: true, script: "docker run --rm -v '${env.WORKSPACE}':/repo:ro softonic/ci-version:0.1.0 --compatible-with package.json").trim()
//                     env.DEPLOY_MAJOR_VERSION = sh(returnStdout: true, script: "echo '${env.DEPLOY_VERSION}' | awk -F'[ .]' '{print \$1}'").trim()
//                     env.DEPLOY_COMMIT_HASH = sh(returnStdout: true, script: "git rev-parse HEAD | cut -c1-7").trim()
//                     env.DEPLOY_BUILD_DATE = sh(returnStdout: true, script: "date -u +'%Y-%m-%dT%H:%M:%SZ'").trim()

//                     env.DEPLOY_STACK_NAME = "${env.STACK_PREFIX}-v${env.DEPLOY_MAJOR_VERSION}"
//                     env.IS_NEW_VERSION = sh(returnStdout: true, script: "[ '${env.DEPLOY_VERSION}' ] && echo 'YES'").trim()
//                 }
//             }
//         }

//         stage("Create new version") {
//             when {
//                 branch "master"
//                 environment name: "IS_NEW_VERSION", value: "YES"
//             }

//             steps {
//                 script {
//                     sshagent(['ci-ssh']) {
//                         sh """
//                             git config user.email "ci-user@email.com"
//                             git config user.name "Jenkins"
//                             git tag -a "v${env.DEPLOY_VERSION}" \
//                                 -m "Generated by: ${env.JENKINS_URL}" \
//                                 -m "Job: ${env.JOB_NAME}" \
//                                 -m "Build: ${env.BUILD_NUMBER}" \
//                                 -m "Env Branch: ${env.BRANCH_NAME}"
//                             git push origin "v${env.DEPLOY_VERSION}"
//                         """
//                     }
//                 }

//                 sh "docker login -u=$REGISTRY_AUTH_USR -p=$REGISTRY_AUTH_PSW ${env.REGISTRY_ADDRESS}"
//                 sh "docker-compose -f ${env.COMPOSE_FILE} build"
//                 sh "docker-compose -f ${env.COMPOSE_FILE} push"
//             }
//         }

//         stage("Deploy to production") {
//             agent { node { label "swarm-prod" } }

//             when {
//                 branch "master"
//                 environment name: "IS_NEW_VERSION", value: "YES"
//             }

//             steps {
//                 sh "docker login -u=$REGISTRY_AUTH_USR -p=$REGISTRY_AUTH_PSW ${env.REGISTRY_ADDRESS}"
//                 sh "docker stack deploy ${env.DEPLOY_STACK_NAME} -c ${env.COMPOSE_FILE} --with-registry-auth"
//             }

//             post {
//                 success {
//                     slackSend(
//                             teamDomain: "${env.SLACK_TEAM_DOMAIN}",
//                             token: "${env.SLACK_TOKEN}",
//                             channel: "${env.SLACK_CHANNEL}",
//                             color: "good",
//                             message: "${env.STACK_PREFIX} production deploy: *${env.DEPLOY_VERSION}*. <${env.DEPLOY_URL}|Access service> - <${env.BUILD_URL}|Check build>"
//                     )
//                 }

//                 failure {
//                     slackSend(
//                             teamDomain: "${env.SLACK_TEAM_DOMAIN}",
//                             token: "${env.SLACK_TOKEN}",
//                             channel: "${env.SLACK_CHANNEL}",
//                             color: "danger",
//                             message: "${env.STACK_PREFIX} production deploy failed: *${env.DEPLOY_VERSION}*. <${env.BUILD_URL}|Check build>"
//                     )
//                 }
//             }
//         }
//     }

//     post {
//         always {
//             sh "docker-compose down || true"
//         }

//         success {
//             bitbucketStatusNotify buildState: "SUCCESSFUL"
//         }

//         failure {
//             bitbucketStatusNotify buildState: "FAILED"
//         }
//     }
// }