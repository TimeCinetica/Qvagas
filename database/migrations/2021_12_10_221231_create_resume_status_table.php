<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateResumeStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        DB::table('resume_status')->insert([
            ['name' => 'Não Avaliado', 'description' => 'Seu currículo ainda não foi avaliado pela equipe da Quallity Psi, o mais breve possível iremos avaliar.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Não qualificado', 'description' => ' Agradecemos sua participação em nosso processo seletivo. Mas, infelizmente você não foi selecionado para a vaga. Caso deseje se cadastrar em outra vaga, atualize seu currículo e mude o campo de Cargo Desejado para uma nova vaga. Você também pode ser membro do nosso grupo QVagas entrando no Telegram. só acessar esse link: https://t.me/joinchat/NW6rnxfR40dQonXg5qCmEA Veja vagas de emprego em: http://qvagas.quallitypsi.com.br/ ou https://www.linkedin.com/company-beta/10451524.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Qualificado', 'description' => 'Seu currículo foi classificado para a próxima etapa e você estará em nosso processo seletivo. Neste status você só pode atualizar seu currículo depois de 30 dias.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Contratado', 'description' => 'Neste status você foi contratado pelo cliente e seu cadastro não pode ser atualizado, caso queira alterar seu currículo entre em contato pelo telefone ou whatsapp 27 9 9272 47 01.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Banco de Dados', 'description' => 'Neste status não temos uma vaga no seu perfil, desta forma para se cadastrar-se a outra vaga atualize seu currículo e mude o campo de Cargo Desejado para uma nova vaga.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Standy By', 'description' => 'Neste status você tem o perfil para vaga, mas já iniciamos o processo seletivo e caso não completarmos o processo entraremos em contato. Desta forma, para se cadastrar-se a outra vaga atualize seu currículo e mude o campo de Cargo Desejado para uma nova vaga.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alinhamento com a vaga', 'description' => ' A equipe entrará em contato para um bate papo pode ser pelo telefone ou vídeo chamada, a fim de verificar algumas questões e mapear se você está alinhado com a vaga e se a vaga está alinhada com suas expectativas.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Espera do contato do contratante', 'description' => 'Nesse momento nossa equipe está esperando o contratante para prosseguir com vaga ou agendar uma entrevista com você ou repassando seus dados ao contratante e ele irá entrar em contato para prosseguir com o processo seletivo.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Testes e Questionário', 'description' => 'Nesta etapa você será submetido a alguns testes e questionários. Essa modalidade depende do tipo de vaga e critérios estabelecidos pelo contratante. Pode ser online ou presencial.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sem candidatura', 'description' => 'Você não está candidatado(a) a nenhuma vaga da Quallity Psi. Lembre-se que nem todas as vagas de emprego do QVagas, são realizadas pela Quallity. Por isso, você pode se candidatar para alguma vaga anunciada pelo QVagas, mas o processo seletivo não está sendo feito por nós.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Entrevista com o contratante', 'description' => 'Nessa etapa você passará por entrevista com o contratante e ele irá escolher quem será o contratado. Às vezes pode demorar essa etapa porque nós estamos esperando a resposta do contratante. Pode ser nossa equipe que irá ligar para você ou a própria empresa que irá entrar em contato. Pode ser online ou presencial.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Testes e Questionário', 'description' => 'Nesta etapa é acontece entrevista com os psicólogos da empresa da Quallity Psi, pode ser aplicado testes psicológicos. Pode ser online ou presencial.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_status');
    }
}
