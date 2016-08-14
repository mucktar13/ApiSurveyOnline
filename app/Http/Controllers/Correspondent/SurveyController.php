<?php
namespace App\Http\Controllers\Correspondent;

use App\Answers1;
use App\Answers2;
use App\Answers3;
use App\Answers4;
use App\Answers5;
use App\Answers6;
use App\Answers7;
use App\Answers8;
use App\Answers9a;
use App\Http\Controllers\Controller;
use App\TraitFractalResponse;
use App\TraitSessionToken;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use PluginCommonSurvey\Libraries\Codes;
use PluginCommonSurvey\Libraries\SurveyCacheKey;
use App\Answers;

class SurveyController  extends Controller
{
    use TraitFractalResponse;

    use TraitSessionToken;

    CONST CACHE_DRAFT_DATA_PREFIX = 'survey:data:user';
    CONST CACHE_DRAFT_STATUS_PREFIX = 'survey:status:user';


    private function getDataCacheKey(){
        return SurveyCacheKey::getInstance()->generateCacheKey(sprintf('%s:%d', self::CACHE_DRAFT_DATA_PREFIX, $this->getSessionUserID()), false);
    }

    private function getStatusCacheKey(){
        return SurveyCacheKey::getInstance()->generateCacheKey(sprintf('%s:%d', self::CACHE_DRAFT_STATUS_PREFIX, $this->getSessionUserID()), false);
    }

    private function runValidation(Request $request){
        // TODO : impelement validation
        return true;
    }

    private function getValueFromNominalFormat($nominal){
        return $nominal;
    }

    private function saveToDatabase(Request $request){
        if(!$this->runValidation($request)){
            return $this->response->errorWrongArgs(trans('validation error happened'));
        }

        DB::transaction(function () use ($request) {
            $answers = $this->createNewAnswers($request);
            $this->createNewAnswers1($answers, $request);
            $this->createNewAnswers2($answers, $request);
            $this->createNewAnswers3($answers, $request);
            $this->createNewAnswers4($answers, $request);
            $this->createNewAnswers5($answers, $request);
            $this->createNewAnswers6($answers, $request);
            $this->createNewAnswers7($answers, $request);
            $this->createNewAnswers8($answers, $request);
            $this->createNewAnswers9a($answers, $request);
            $this->createNewAnswers9b($answers, $request);
            $this->createNewAnswers9c($answers, $request);
            $this->createNewAnswers10($answers, $request);
            $this->createNewAnswers11($answers, $request);
            $this->createNewAnswers12($answers, $request);
            $this->createNewAnswers13($answers, $request);
            $this->createNewAnswers14($answers, $request);
            $this->createNewAnswers15($answers, $request);
            $this->createNewAnswers16($answers, $request);
            $this->createNewAnswers17($answers, $request);
            $this->createNewAnswers18($answers, $request);
        });

        return true;
    }

    private function createNewAnswers(Request $request){
        $answers =  Answers::firstOrNew(['id_correspondent' => $this->getSessionUserID()]);
        $answers->status = 'pengisian';
        $answers->save();

        return $answers;
    }

    private function createNewAnswers1(Answers $answers, Request $request){
        $answers1 =  Answers1::firstOrNew(['id_answer' => $answers->id_answer]);
        $answers1->total = $this->getValueFromNominalFormat($request->input('data.answer1_total'));
        $answers1->percentage = $request->input('data.answer1_percentage');
        $answers1->save();
    }

    private function createNewAnswers2(Answers $answers, Request $request){
        $answers2 =  Answers2::firstOrNew(['id_answer' => $answers->id_answer]);
        $answers2->jumlah = $this->getValueFromNominalFormat($request->input('data.answer2_jumlah'));
        $answers2->save();
    }

    private function createNewAnswers3(Answers $answers, Request $request){
        $answers3 =  Answers3::firstOrNew(['id_answer' => $answers->id_answer]);
        $answers3->dipa_danapemerintah = $this->getValueFromNominalFormat($request->input('data.answer3_dipa_danapemerintah'));
        $answers3->dipa_pnbp_perusahaanswasta = $this->getValueFromNominalFormat($request->input('data.answer3_dipa_pnbp_perusahaanswasta'));
        $answers3->dipa_pnbp_instansipemerintah = $this->getValueFromNominalFormat($request->input('data.answer3_dipa_pnbp_instansipemerintah'));
        $answers3->dipa_pnbp_swastanonprofit = $this->getValueFromNominalFormat($request->input('data.answer3_dipa_pnbp_swastanonprofit '));
        $answers3->dipa_pnbp_luarnegeri = $this->getValueFromNominalFormat($request->input('data.answer3_dipa_pnbp_luarnegeri '));
        $answers3->dipa_phln = $this->getValueFromNominalFormat($request->input('data.answer3_dipa_phln '));
        $answers3->nondipa_insentif_ristekdikti = $this->getValueFromNominalFormat($request->input('data.answer3_nondipa_insentif_ristekdikti '));
        $answers3->nondipa_insentif_dalamnegeri = $this->getValueFromNominalFormat($request->input('data.answer3_nondipa_insentif_dalamnegeri '));
        $answers3->nondipa_insentif_researchgrant = $this->getValueFromNominalFormat($request->input('data.answer3_nondipa_insentif_researchgrant '));
        $answers3->save();
    }

    private function createNewAnswers4(Answers $answers, Request $request){
        $answers4 =  Answers4::firstOrNew(['id_answer' => $answers->id_answer]);
        $answers4->belanja_pegawai_upah = $this->getValueFromNominalFormat($request->input('data.answer4_belanja_pegawai_upah'));
        $answers4->belanja_modal_properti = $this->getValueFromNominalFormat($request->input('data.answer4_belanja_modal_properti'));
        $answers4->belanja_modal_mesin = $this->getValueFromNominalFormat($request->input('data.answer4_belanja_modal_mesin'));
        $answers4->belanja_operasional_maintenance = $this->getValueFromNominalFormat($request->input('data.answer4_belanja_operasional_maintenance '));
        $answers4->save();
    }

    private function createNewAnswers5(Answers $answers, Request $request){
        $deletedRows = Answers5::where('id_answer', $answers->id_answer)->delete();

        $codes = $request->input('data.answer5_code');
        $percentages = $request->input('data.answer5_percentage');

        foreach($codes as $row_index => $code){
            $answers5 = new Answers5;
            $answers5->code = $code;
            $answers5->percentage = $percentages[$row_index];
            $answers5->save();
        }
    }

    private function createNewAnswers6(Answers $answers, Request $request){
        $deletedRows = Answers6::where('id_answer', $answers->id_answer)->delete();

        $codes = $request->input('data.answer6_code');
        $percentages = $request->input('data.answer6_percentage');

        foreach($codes as $row_index => $code){
            $answers6 = new Answers6;
            $answers6->code = $code;
            $answers6->percentage = $percentages[$row_index];
            $answers6->save();
        }
    }

    private function createNewAnswers7(Answers $answers, Request $request){
        $answers7 =  Answers7::firstOrNew(['id_answer' => $answers->id_answer]);
        $answers7->penelitian_dasar = $this->getValueFromNominalFormat($request->input('data.answer7_penelitian_dasar'));
        $answers7->penelitian_terapan = $this->getValueFromNominalFormat($request->input('data.answer7_penelitian_terapan'));
        $answers7->pengembangan_eksperimental = $this->getValueFromNominalFormat($request->input('data.answer7_pengembangan_eksperimental'));
        $answers7->save();
    }

    private function createNewAnswers8(Answers $answers, Request $request){
        $deletedRows = Answers8::where('id_answer', $answers->id_answer)->delete();

        $codes = $request->input('data.answer8_code');
        $percentages = $request->input('data.answer8_percentage');

        foreach($codes as $row_index => $code){
            $answers8 = new Answers8;
            $answers8->code = $code;
            $answers8->percentage = $percentages[$row_index];
            $answers8->save();
        }
    }

    private function createNewAnswers9a(Answers $answers, Request $request){
        $answers9a =  Answers9a::firstOrNew(['id_answer' => $answers->id_answer]);
        $answers9a->total_pegawai = $request->input('data.answer9a_total_pegawai');
        $answers9a->save();
    }

    private function createNewAnswers9b(Answers $answers, Request $request){
        //1.1 Peneliti dengan jabatan fungsional Peneliti
        $answers9b =  Answers9b::firstOrNew(['id_answer' => $answers->id_answer]);
        $answers9b->peneliti_fungsional_peneliti_s1_l = $request->input('data.answer9b_peneliti_fungsional_peneliti_s1_l');
        $answers9b->peneliti_fungsional_peneliti_s1_p = $request->input('data.answer9b_peneliti_fungsional_peneliti_s1_p');
        $answers9b->peneliti_fungsional_peneliti_s1_fte_l = $request->input('data.answer9b_peneliti_fungsional_peneliti_s1_fte_l');
        $answers9b->peneliti_fungsional_peneliti_s1_fte_p = $request->input('data.answer9b_peneliti_fungsional_peneliti_s1_fte_p');

        $answers9b->peneliti_fungsional_peneliti_s2_l = $request->input('data.answer9b_peneliti_fungsional_peneliti_s2_l');
        $answers9b->peneliti_fungsional_peneliti_s2_p = $request->input('data.answer9b_peneliti_fungsional_peneliti_s2_p');
        $answers9b->peneliti_fungsional_peneliti_s2_fte_l = $request->input('data.answer9b_peneliti_fungsional_peneliti_s2_fte_l');
        $answers9b->peneliti_fungsional_peneliti_s2_fte_p = $request->input('data.answer9b_peneliti_fungsional_peneliti_s2_fte_p');

        $answers9b->peneliti_fungsional_peneliti_s3_l = $request->input('data.answer9b_peneliti_fungsional_peneliti_s3_l');
        $answers9b->peneliti_fungsional_peneliti_s3_p = $request->input('data.answer9b_peneliti_fungsional_peneliti_s3_p');
        $answers9b->peneliti_fungsional_peneliti_s3_fte_l = $request->input('data.answer9b_peneliti_fungsional_peneliti_s3_fte_l');
        $answers9b->peneliti_fungsional_peneliti_s3_fte_p = $request->input('data.answer9b_peneliti_fungsional_peneliti_s3_fte_p');

        //1.2 Peneliti dengan jabatan fungsional Non Peneliti
        $answers9b->peneliti_fungsional_nonpeneliti_s1_l = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s1_l');
        $answers9b->peneliti_fungsional_nonpeneliti_s1_p = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s1_p');
        $answers9b->peneliti_fungsional_nonpeneliti_s1_fte_l = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s1_fte_l');
        $answers9b->peneliti_fungsional_nonpeneliti_s1_fte_p = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s1_fte_p');

        $answers9b->peneliti_fungsional_nonpeneliti_s2_l = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s2_l');
        $answers9b->peneliti_fungsional_nonpeneliti_s2_p = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s2_p');
        $answers9b->peneliti_fungsional_nonpeneliti_s2_fte_l = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s2_fte_l');
        $answers9b->peneliti_fungsional_nonpeneliti_s2_fte_p = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s2_fte_p');

        $answers9b->peneliti_fungsional_nonpeneliti_s3_l = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s3_l');
        $answers9b->peneliti_fungsional_nonpeneliti_s3_p = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s3_p');
        $answers9b->peneliti_fungsional_nonpeneliti_s3_fte_l = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s3_fte_l');
        $answers9b->peneliti_fungsional_nonpeneliti_s3_fte_p = $request->input('data.answer9b_peneliti_fungsional_nonpeneliti_s3_fte_p');

        //1.3 Peneliti tanpa jabatan fungsional
        $answers9b->peneliti_nonfungsional_s1_l = $request->input('data.answer9b_peneliti_nonfungsional_s1_l');
        $answers9b->peneliti_nonfungsional_s1_p = $request->input('data.answer9b_peneliti_nonfungsional_s1_p');
        $answers9b->peneliti_nonfungsional_s1_fte_l = $request->input('data.answer9b_peneliti_nonfungsional_s1_fte_l');
        $answers9b->peneliti_nonfungsional_s1_fte_p = $request->input('data.answer9b_peneliti_nonfungsional_s1_fte_p');

        $answers9b->peneliti_nonfungsional_s2_l = $request->input('data.answer9b_peneliti_nonfungsional_s2_l');
        $answers9b->peneliti_nonfungsional_s2_p = $request->input('data.answer9b_peneliti_nonfungsional_s2_p');
        $answers9b->peneliti_nonfungsional_s2_fte_l = $request->input('data.answer9b_peneliti_nonfungsional_s2_fte_l');
        $answers9b->peneliti_nonfungsional_s2_fte_p = $request->input('data.answer9b_peneliti_nonfungsional_s2_fte_p');

        $answers9b->peneliti_nonfungsional_s3_l = $request->input('data.answer9b_peneliti_nonfungsional_s3_l');
        $answers9b->peneliti_nonfungsional_s3_p = $request->input('data.answer9b_peneliti_nonfungsional_s3_p');
        $answers9b->peneliti_nonfungsional_s3_fte_l = $request->input('data.answer9b_peneliti_nonfungsional_s3_fte_l');
        $answers9b->peneliti_nonfungsional_s3_fte_p = $request->input('data.answer9b_peneliti_nonfungsional_s3_fte_p');

        // 2. Teknisi
        $answers9b->teknisi_s1_l = $request->input('data.answer9b_teknisi_s1_l');
        $answers9b->teknisi_s1_p = $request->input('data.answer9b_teknisi_s1_p');
        $answers9b->teknisi_s1_fte_l = $request->input('data.answer9b_teknisi_s1_fte_l');
        $answers9b->teknisi_s1_fte_p = $request->input('data.answer9b_teknisi_s1_fte_p');

        $answers9b->teknisi_d3_l = $request->input('data.answer9b_teknisi_d3_l');
        $answers9b->teknisi_d3_p = $request->input('data.answer9b_teknisi_d3_p');
        $answers9b->teknisi_d3_fte_l = $request->input('data.answer9b_teknisi_d3_fte_l');
        $answers9b->teknisi_d3_fte_p = $request->input('data.answer9b_teknisi_d3_fte_p');

        $answers9b->teknisi_belowd3_l = $request->input('data.answer9b_teknisi_belowd3_l');
        $answers9b->teknisi_belowd3_p = $request->input('data.answer9b_teknisi_belowd3_p');
        $answers9b->teknisi_belowd3_fte_l = $request->input('data.answer9b_teknisi_belowd3_fte_l');
        $answers9b->teknisi_belowd3_fte_p = $request->input('data.answer9b_teknisi_belowd3_fte_p');

        // 3. Staf Pendukung Litbang Lainnya (a+b+c)
        $answers9b->staffpendukung_s1_l = $request->input('data.answer9b_staffpendukung_s1_l');
        $answers9b->staffpendukung_s1_p = $request->input('data.answer9b_staffpendukung_s1_p');
        $answers9b->staffpendukung_s1_fte_l = $request->input('data.answer9b_staffpendukung_s1_fte_l');
        $answers9b->staffpendukung_s1_fte_p = $request->input('data.answer9b_staffpendukung_s1_fte_p');

        $answers9b->staffpendukung_d3_l = $request->input('data.answer9b_staffpendukung_d3_l');
        $answers9b->staffpendukung_d3_p = $request->input('data.answer9b_staffpendukung_d3_p');
        $answers9b->staffpendukung_d3_fte_l = $request->input('data.answer9b_staffpendukung_d3_fte_l');
        $answers9b->staffpendukung_d3_fte_p = $request->input('data.answer9b_staffpendukung_d3_fte_p');

        $answers9b->staffpendukung_belowd3_l = $request->input('data.answer9b_staffpendukung_belowd3_l');
        $answers9b->staffpendukung_belowd3_p = $request->input('data.answer9b_staffpendukung_belowd3_p');
        $answers9b->staffpendukung_belowd3_fte_l = $request->input('data.answer9b_staffpendukung_belowd3_fte_l');
        $answers9b->staffpendukung_belowd3_fte_p = $request->input('data.answer9b_staffpendukung_belowd3_fte_p');

        $answers9b->save();
    }

    private function getDataDraftFromCache(){
        if($data = Cache::get($this->getDataCacheKey())){
            return $data;
        }

        return [];
    }

    private function getStatusDraftFromCache(){
        if($status = Cache::get($this->getStatusCacheKey())){
            return $status;
        }

        return [];
    }

    public function store(Request $request)
    {
        $this->saveToDatabase($request);

        return $this->response->setStatusCode(201)->withArray([
            'code' => Codes::SUCCESS,
            'message' => trans('survey.successsavesurvey')
        ]);
    }

    public function index(){
        return $this->response->withArray([
                'data' => $this->getDataDraftFromCache(),
                'status' => $this->getStatusDraftFromCache(),
            ]
        );
    }

    public function draftdata(){
        return $this->response->withArray($this->getDataDraftFromCache());
    }

    public function draftstatus(){
        return $this->response->withArray($this->getStatusDraftFromCache());
    }

}
