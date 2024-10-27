<?php
namespace Ari_Stream_Quiz\Controllers\Quizzes;

use Ari\Controllers\Controller;
use Ari\Utils\Response;
use Ari\Utils\Request;
use Ari_Stream_Quiz\Helpers\Helper;

class Copy extends Controller {
    public function execute() {
        check_admin_referer( 'asq-quiz' );

        $result = false;
        $model = $this->model();

        if ( Request::exists( 'action_quiz_id' ) ) {
            $quiz_id = Request::get_var( 'action_quiz_id', 0, 'num' );

            if ( $quiz_id > 0 && Helper::can_edit_quiz( $quiz_id ) ) {
                $result = $model->copy( $quiz_id );
            }
        }

        if ( $result ) {
            Response::redirect(
                Helper::build_url(
                    array(
                        'page' => 'ari-stream-quiz-quizzes',

                        'filter' => $model->encoded_filter_state(),

                        'msg' => __( 'Copy of the quiz created successfully', 'ari-stream-quiz' ),

                        'msg_type' => ARISTREAMQUIZ_MESSAGETYPE_SUCCESS,
                    )
                )
            );
        } else {
            Response::redirect(
                Helper::build_url(
                    array(
                        'page' => 'ari-stream-quiz-quizzes',

                        'filter' => $model->encoded_filter_state(),

                        'msg' => __( 'A copy of the quiz is not created', 'ari-stream-quiz' ),

                        'msg_type' => ARISTREAMQUIZ_MESSAGETYPE_ERROR,
                    )
                )
            );
        }
    }
}