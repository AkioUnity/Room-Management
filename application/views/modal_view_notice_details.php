<h3><?php echo $this->security->xss_clean($this->db->get_where('notice', array('notice_id' => $param2))->row()->title); ?></h3>
<p>Published on: <?php echo date('d M, Y', $this->db->get_where('notice', array('notice_id' => $param2))->row()->created_on); ?> &nbsp;&nbsp;&nbsp; Last updated: <?php echo date('d M, Y', $this->db->get_where('notice', array('notice_id' => $param2))->row()->timestamp); ?></p>
<hr>
<p><?php echo $this->security->xss_clean($this->db->get_where('notice', array('notice_id' => $param2))->row()->notice); ?></p>