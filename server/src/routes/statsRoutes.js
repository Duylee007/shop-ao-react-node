import { Router } from 'express';
import { getDashboardStats } from '../controllers/statsController.js';
import { verifyAdmin } from '../middlewares/authMiddleware.js';

const router = Router();

router.get('/', verifyAdmin, getDashboardStats);

export default router;
