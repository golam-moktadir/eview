<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Join_model extends CI_Model {

    public function product_by_subcat($subcat_id) {
        $this->db->select('PD.*, CG.category as cat, SC.sub_category sub_cat');
        $this->db->from('product as PD');
        $this->db->order_by('PD.name', 'ASC');
        $this->db->join('sub_category as SC', "PD.sub_category = SC.record_id", 'left');
        $this->db->join('category as CG', "PD.category = CG.record_id", 'left');
        $this->db->where('PD.sub_category', $subcat_id);
        return $this->db->get()->result();
    }

    function get_inex_amount($table_name, $arr) {
        $this->db->select_sum('amount');
        $this->db->where($arr);
        $query = $this->db->get($table_name);
        $result = $query->row()->amount;
        if (empty($query)) {
            return 0;
        } else {
            return $result;
        }
    }

    // public function get_mer_reg() {
    //     $this->db->select('MR.*, CG.category as cat, SC.sub_category as sub_cat');
    //     $this->db->from('mer_reg as MR');
    //     $this->db->order_by('MR.record_id', 'DESC');
    //     $this->db->join('category as CG', "MR.category = CG.record_id", 'left');
    //     $this->db->join('sub_category as SC', "MR.sub_category = SC.record_id", 'left');
    //     return $this->db->get()->result();
    // }
    public function get_mer_reg() {
        $this->db->select('MR.*, CG.category as cat');
        $this->db->from('mer_reg as MR');
        $this->db->order_by('MR.record_id', 'DESC');
        $this->db->join('category as CG', "MR.category = CG.record_id", 'left');
        return $this->db->get()->result();
    }
    public function get_all_sub_category() {
        $this->db->select('SC.*, CG.category');
        $this->db->from('sub_category as SC');
        $this->db->order_by('SC.record_id', 'DESC');
        $this->db->join('category as CG', "SC.category_id = CG.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_all_product() {
        $this->db->select('PD.*, CG.category as cat, SC.sub_category as sub_cat, brands.*');
        $this->db->from('product as PD');
        $this->db->order_by('PD.record_id', 'DESC');
        $this->db->join('category as CG', "PD.category = CG.record_id", 'left');
        $this->db->join('sub_category as SC', "PD.sub_category = SC.record_id", 'left');
        $this->db->join('brands', "PD.brand = brands.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_all_product_mer($member_id) {
        $this->db->select('PD.*, CG.category as cat, SC.sub_category as sub_cat, brands.*');
        $this->db->where("PD.member_id", $member_id);
        $this->db->from('product as PD');
        $this->db->order_by('PD.record_id', 'DESC');
        $this->db->join('category as CG', "PD.category = CG.record_id", 'left');
        $this->db->join('sub_category as SC', "PD.sub_category = SC.record_id", 'left');
        $this->db->join('brands', "PD.brand = brands.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_all_info_ambulance() {
        $this->db->select('amb.*, PT.patient_name');
        $this->db->from('ambulance as amb');
        $this->db->order_by('amb.record_id', 'DESC');
        $this->db->join('patient as PT', "amb.patient_id = PT.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_all_info_cabin() {
        $this->db->select('cab.*, PT.patient_name');
        $this->db->from('cabin as cab');
        $this->db->order_by('cab.record_id', 'DESC');
        $this->db->join('patient as PT', "cab.patient_id = PT.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_appointment() {
        $this->db->select('app.*, PT.patient_name, DC.name');
        $this->db->from('appointment as app');
        $this->db->order_by('app.record_id', 'DESC');
        $this->db->join('patient as PT', "app.patient_id = PT.record_id", 'left');
        $this->db->join('doc_con as DC', "app.doc_id = DC.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_appointment_byid($id) {
        $this->db->select('app.*, PT.patient_name, DC.name');
        $this->db->from('appointment as app');
        $this->db->join('patient as PT', "app.patient_id = PT.record_id", 'left');
        $this->db->join('doc_con as DC', "app.doc_id = DC.record_id", 'left');
        $this->db->where("app.record_id", $id);
        return $this->db->get()->result();
    }

    public function get_expense() {
        $this->db->select('EX.*, EH.head, RS.full_name as paid_by');
        $this->db->from('expense as EX');
        $this->db->join('expense_head as EH', "EX.head_id = EH.record_id", 'left');
        $this->db->join('role_setting as RS', "EX.paid_by_id = RS.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_income() {
        $this->db->select('IN.*, IH.head, RS.full_name as paid_by');
        $this->db->from('income as IN');
        $this->db->join('income_head as IH', "IN.head_id = IH.record_id", 'left');
        $this->db->join('role_setting as RS', "IN.paid_by_id = RS.record_id", 'left');
        return $this->db->get()->result();
    }

    public function get_rec_inv() {
        $this->db->select('IR.*, SUM(IR.rate) as rate,'
                . 'PA.patient_name, DC.name as doc_name, INV.investigation_name');
        $this->db->from('inv_receipt as IR');
        $this->db->order_by('IR.record_id', 'DESC');
        $this->db->join('patient as PA', "IR.patient_id = PA.record_id", 'left');
        $this->db->join('doc_con as DC', "IR.ref_doc_id = DC.record_id", 'left');
        $this->db->join('investigation as INV', "IR.inv_id = INV.record_id", 'left');
        $this->db->group_by('unique_id');
        return $this->db->get()->result();
    }

    public function get_rec_inv_byid($inv_id) {
        $this->db->select('IR.*, PA.patient_name, PA.sex, PA.contact, DC.designation, DC.name as doc_name, INV.investigation_name');
        $this->db->from('inv_receipt as IR');
        $this->db->order_by('IR.record_id', 'DESC');
        $this->db->join('patient as PA', "IR.patient_id = PA.record_id", 'left');
        $this->db->join('doc_con as DC', "IR.ref_doc_id = DC.record_id", 'left');
        $this->db->join('investigation as INV', "IR.inv_id = INV.record_id", 'left');
        $this->db->where("unique_id", $inv_id);
        return $this->db->get()->result();
    }

    public function get_rec_op() {
        $this->db->select('OPR.*, SUM(OPR.operation_charge) as opc, SUM(OPR.ot_charge) as oc, PA.patient_name, DC.name as doc_name, UN.unit_name, GR.grade_name');
        $this->db->from('op_receipt as OPR');
        $this->db->join('patient as PA', "OPR.patient_id = PA.record_id", 'left');
        $this->db->join('doc_con as DC', "OPR.ref_doc_id = DC.record_id", 'left');
        $this->db->join('unit as UN', "OPR.ref_unit_id = UN.record_id", 'left');
        $this->db->join('grade as GR', "OPR.grade_id = GR.record_id", 'left');
        $this->db->group_by('unique_id');
        return $this->db->get()->result();
    }

    public function get_rec_op_byid($inv_id) {
        $this->db->select('OPR.*, PA.patient_name, DC.name as doc_name, UN.unit_name, GR.grade_name');
        $this->db->from('op_receipt as OPR');
        $this->db->join('patient as PA', "OPR.patient_id = PA.record_id", 'left');
        $this->db->join('doc_con as DC', "OPR.ref_doc_id = DC.record_id", 'left');
        $this->db->join('unit as UN', "OPR.ref_unit_id = UN.record_id", 'left');
        $this->db->join('grade as GR', "OPR.grade_id = GR.record_id", 'left');
        $this->db->where("unique_id", $inv_id);
        return $this->db->get()->result();
    }

    public function get_rec_op_ev() {
        $this->db->select('OPR.*, SUM(OPR.operation_charge) as opc, SUM(OPR.ot_charge) as oc, PA.patient_name, DC.name as doc_name, UN.unit_name, GR.grade_name');
        $this->db->from('op_receipt_ev as OPR');
        $this->db->join('patient as PA', "OPR.patient_id = PA.record_id", 'left');
        $this->db->join('doc_con as DC', "OPR.ref_doc_id = DC.record_id", 'left');
        $this->db->join('unit as UN', "OPR.ref_unit_id = UN.record_id", 'left');
        $this->db->join('grade as GR', "OPR.grade_id = GR.record_id", 'left');
        $this->db->group_by('unique_id');
        return $this->db->get()->result();
    }

    public function get_rec_op_byid_ev($inv_id) {
        $this->db->select('OPR.*, PA.patient_name, DC.name as doc_name, UN.unit_name, GR.grade_name');
        $this->db->from('op_receipt_ev as OPR');
        $this->db->join('patient as PA', "OPR.patient_id = PA.record_id", 'left');
        $this->db->join('doc_con as DC', "OPR.ref_doc_id = DC.record_id", 'left');
        $this->db->join('unit as UN', "OPR.ref_unit_id = UN.record_id", 'left');
        $this->db->join('grade as GR', "OPR.grade_id = GR.record_id", 'left');
        $this->db->where("unique_id", $inv_id);
        return $this->db->get()->result();
    }

}

?>