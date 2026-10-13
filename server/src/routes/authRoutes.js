import { Router } from 'express';
import {
  register,
  login,
  adminLogin,
  getMe
} from '../controllers/authController.js';
import { verifyToken } from '../middlewares/authMiddleware.js';

const router = Router();

router.post('/register', register);
router.post('/login', login);
router.post('/admin-login', adminLogin);
router.get('/me', verifyToken, getMe);

export default router;
